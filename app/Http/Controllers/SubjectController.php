<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = config('pagination.subjects.per_page', 12);
        $subjects = Subject::paginate($perPage);

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.subject');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        try {
            $data = $request->validated();

            Subject::create($data);

            return redirect()->route('subjects.index')->with('notification', __('subject.subject_created'));
        } catch (\Throwable $e) {
            Log::error('Subject create failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('subject.subject_create_failed'))->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.subject', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        try {
            $data = $request->validated();
            $subject->update($data);

            return redirect()->route('subjects.edit', $subject)->with('notification', __('subject.subject_updated'));
        } catch (\Throwable $e) {
            Log::error('Subject update failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('subject.subject_update_failed'))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();

            return back()->with('notification', __('subject.subject_deleted'));
        } catch (\Throwable $e) {
            Log::error('Subject delete failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('notification', __('subject.subject_delete_failed'));
        }
    }
}
