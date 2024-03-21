<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {

            if ($request->is('admin') ||$request->is('*/admin') ||$request->is('*/admin/*') ||$request->is('admin/*') || request()->segment(1) == 'admin') {
                return route('login');
            } else if ($request->is('teacher') ||$request->is('*/teacher') ||$request->is('*/teacher/*') ||$request->is('teacher/*') || request()->segment(1) == 'teacher') {

                return redirect()->route('teacher.get.login');
            }
        }

        return $request->expectsJson() ? null : route('login');
    }
}
