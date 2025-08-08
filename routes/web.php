<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(callback: function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])
        ->name('login.form');

    Route::post('login', [AuthController::class, 'login'])
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])
            ->name('index');

        Route::get('create', [CourseController::class, 'create'])
            ->name('create');

        Route::post('store', [CourseController::class, 'store'])
            ->name('store');

        Route::get('{course}', [CourseController::class, 'show'])
            ->name('show');

        Route::get('{course}/edit', [CourseController::class, 'edit'])
            ->name('edit');

        Route::put('{course}', [CourseController::class, 'update'])
            ->name('update');

        Route::delete('{course}', [CourseController::class, 'destroy'])
            ->name('destroy');

        Route::post('{course}/start', [CourseController::class, 'startCourse'])
            ->name('start');

        Route::post('{course}/finish', [CourseController::class, 'finishCourse'])
            ->name('finish');

        Route::post('{course}/subjects/{subject}/start', [CourseController::class, 'startSubjectOfCourse'])
            ->name('subject.start');

        Route::post('{course}/subjects/{subject}/finish', [CourseController::class, 'finishSubjectOfCourse'])
            ->name('subject.finish');

        Route::post('{course}/subjects', [CourseController::class, 'addSubjectToCourse'])
            ->name('subject.add');

        Route::get('{course}/subjects/form', [CourseController::class, 'showAddSubjectToCourse'])
            ->name('subject.form');

        Route::delete('{course}/subjects/{subject}', [CourseController::class, 'removeSubjectFromCourse'])
            ->name('subject.remove');

        Route::prefix('{course}/subjects/{subject}')->name('tasks.')->group(function () {
            Route::get('create', [TaskController::class, 'create'])
                ->name('create');

            Route::post('store', [TaskController::class, 'store'])
                ->name('store');
        });
        Route::get('{course}/trainees', [CourseController::class, 'trainees'])
            ->name('trainees.index');

        Route::get('{course}/trainees/form', [CourseController::class, 'showAddTrainee'])
            ->name('trainees.create');

        Route::post('{course}/trainees', [CourseController::class, 'addTrainee'])
            ->name('trainees.add');

        Route::delete('{course}/trainees/{trainee}', [CourseController::class, 'removeTrainee'])
            ->name('trainees.remove');

        Route::get('{course}/supervisors', [CourseController::class, 'supervisors'])
            ->name('supervisors.index');

        Route::get('{course}/supervisors/form', [CourseController::class, 'showAddSupervisor'])
            ->name('supervisors.create');

        Route::post('{course}/supervisors', [CourseController::class, 'addSupervisor'])
            ->name('supervisors.add');

        Route::delete('{course}/supervisors/{supervisor}', [CourseController::class, 'removeSupervisor'])
            ->name('supervisors.remove');
    });

    Route::prefix('subjects')->name('subjects.')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])
            ->name('index');

        Route::get('create', [SubjectController::class, 'create'])
            ->name('create');

        Route::post('store', [SubjectController::class, 'store'])
            ->name('store');

        Route::get('{subject}/edit', [SubjectController::class, 'edit'])
            ->name('edit');

        Route::put('{subject}', [SubjectController::class, 'update'])
            ->name('update');

        Route::delete('{subject}', [SubjectController::class, 'destroy'])
            ->name('destroy');
    });

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('{task}/edit', [TaskController::class, 'edit'])
            ->name('edit');

        Route::put('{task}', [TaskController::class, 'update'])
            ->name('update');

        Route::delete('{task}', [TaskController::class, 'destroy'])
            ->name('destroy');

        Route::prefix('{task}/reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'getUserTasksOfATaskWithLastedReport'])->name('user_tasks');

            Route::get('users/{user}', [ReportController::class, 'getReportsOfAUserTask'])->name('user_task');

            Route::post('users/{user}', [ReportController::class, 'commentAUserTask'])->name('comment');

            Route::post('users/{user}/done', [ReportController::class, 'markAsDone'])->name('done');
        });
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'indexTrainee'])
            ->name('index');

        Route::get('create', [UserController::class, 'createTrainee'])
            ->name('create');

        Route::post('/', [UserController::class, 'storeTrainee'])
            ->name('store');

        Route::get('{user}/edit', [UserController::class, 'editTrainee'])
            ->name('edit');

        Route::put('{user}', [UserController::class, 'updateTrainee'])
            ->name('update');
    });
});
