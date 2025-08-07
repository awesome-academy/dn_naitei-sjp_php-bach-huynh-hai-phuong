<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

abstract class Controller
{
    protected function backWithNotification(string $message): RedirectResponse
    {
        return back()->with('notification', $message);
    }
}
