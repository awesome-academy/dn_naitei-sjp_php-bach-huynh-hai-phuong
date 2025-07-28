<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enums\CourseStatus;
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'featured_image' => ['required', 'image', 'max:2048'],
        ]);

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
        $courseDetails = [
            'started_at' => $course->started_at ? $course->started_at->format('M j, Y') : '?',
            'finished_at' => $course->finished_at ? $course->finished_at->format('M j, Y') : '?',
            'created_at' => $course->created_at->format('M j, Y'),
            'updated_at' => $course->updated_at->format('M j, Y'),
            'status' => $course->status ? $course->status->value : CourseStatus::DRAFT->value,
        ];
        return view('courses.show', compact('course', 'courseDetails'));
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
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
        ]);

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
