<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateTraineeRequest;
use App\Http\Requests\User\UpdateTraineeRequest;
use App\Models\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function indexTrainee()
    {
        $users = User::where('role', Role::TRAINEE)->paginate(config('pagination.users.per_page', 12));

        return view('users.index', compact('users'));
    }

    public function createTrainee()
    {
        return view('users.user');
    }

    public function storeTrainee(CreateTraineeRequest $request)
    {
        $data = $request->validated();

        try {
            $isExistEmail = User::where('email', $data['email'])->exists();

            if ($isExistEmail) {
                return $this->backWithNotification(__('user.email_already_exist'));
            }

            User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'role' => Role::TRAINEE,
            ]);

            return redirect()
                ->route('users.index')
                ->with('notification', __('user.user_created'));
        } catch (\Throwable $e) {
            Log::error('User create failed: ' . $e->getMessage(), ['exception' => $e]);
            return $this->backWithNotification(__('user.user_create_failed'));
        }
    }

    public function editTrainee(User $user)
    {
        if ($user->role != Role::TRAINEE) {
            abort(404);
        }

        return view('users.user', compact('user'));
    }

    public function updateTrainee(UpdateTraineeRequest $request, User $user)
    {
        if ($user->role != Role::TRAINEE) {
            abort(404);
        }

        $data = $request->validated();

        try {
            $updateDate = [];
            $updateDate['name'] = $data['name'];
            if ($data['password']) {
                $updateDate['password'] = Hash::make($data['password']);
            }

            $user->update($updateDate);

            if ($data['password']) {
                $user->tokens()->delete();
            }

            return redirect()
                ->route('users.edit', $user->id)
                ->with('notification', __('user.user_updated'));
        } catch (\Throwable $e) {
            Log::error('User update failed: ' . $e->getMessage(), ['exception' => $e]);
            return $this->backWithNotification(__('user.user_updated_failed'));
        }
    }
}
