<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\AddSubjectRequest;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Enums\CourseStatus;
use App\Models\Enums\CourseSubjectStatus;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = config('pagination.courses.per_page', 12);
        $courses = Course::paginate($perPage);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.course');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCourseRequest $request)
    {
        $data = $request->validated();

        try {
            $data['featured_image'] = $this->uploadImage($request);

            Course::create($data);

            return redirect()->route('courses.index')->with('notification', __('course.course_created'));
        } catch (\Throwable $e) {
            Log::error('Course create failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('course.course_create_failed'))->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('subjects');

        $subjects = $course->subjects->map(function ($subject) {
            $subject->status = optional($subject->pivot)->status ?: CourseSubjectStatus::NOT_STARTED->value;
            $subject->started_at = formatDate(optional($subject->pivot)->started_at);
            $subject->finished_at = formatDate(optional($subject->pivot)->finished_at);
            $subject->estimated_duration_days = optional($subject->pivot)->estimated_duration_days;
            return $subject;
        });

        $courseDetails = [
            'started_at' => formatDate($course->started_at),
            'finished_at' => formatDate($course->finished_at),
            'created_at' => formatDate($course->created_at),
            'updated_at' => formatDate($course->updated_at),
            'status' => $course->status ? $course->status->value : CourseStatus::DRAFT->value,
        ];
        return view('courses.show', compact('course', 'courseDetails', 'subjects'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('courses.course', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('featured_image')) {
                $this->deleteImage($course->featured_image);
                $data['featured_image'] = $this->uploadImage($request);
            }

            $course->update($data);

            return redirect()
                ->route('courses.show', $course->id)
                ->with('notification', __('course.course_updated'));
        } catch (\Throwable $e) {
            Log::error('Course update failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('course.course_update_failed'))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $this->deleteImage($course->featured_image);

            $course->delete();

            return redirect()->route('courses.index')->with('notification', __('course.course_deleted'));
        } catch (\Throwable $e) {
            Log::error('Course delete failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('course.course_delete_failed'))->withInput();
        }
    }

    public function showAddSubject(Course $course)
    {
        $subjects = $course->subjects()->select('subjects.id')->pluck('subjects.id')->toArray();
        $availableSubjects = Subject::whereNotIn('id', $subjects)->get();

        $formattedAvailableSubjects = $availableSubjects->map(function ($subject) {
            return [
                'value' => $subject->id,
                'title' => $subject->title,
            ];
        })->toArray();

        return view('courses.add-subject', compact('course', 'formattedAvailableSubjects'));
    }

    public function addSubject(AddSubjectRequest $request, Course $course)
    {
        $data = $request->validated();

        try {
            $alreadyAdded = $course->subjects()->where('subject_id', $data['subject_id'])->exists();
            if ($alreadyAdded) {
                return back()->with('notification', __('course_subject.already_attached'))->withInput();
            }

            $maxSortOrder = $course->subjects()->max('sort_order') ?? 0;
            $data['sort_order'] = $maxSortOrder + 1;

            $course->subjects()->attach($data['subject_id'], [
                'sort_order' => $data['sort_order'],
                'estimated_duration_days' => $data['estimated_duration_days'],
            ]);

            return redirect()->route('courses.show', $course->id)->with('notification', __('course_subject.added'));
        } catch (\Throwable $e) {
            Log::error('Add subject to course failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('course_subject.add_failed'))->withInput();
        }
    }

    protected function uploadImage(Request $request, string $field = 'featured_image'): ?string
    {
        if ($request->hasFile($field)) {
            return $request->file($field)->store('courses', 'public');
        }
        return null;
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
