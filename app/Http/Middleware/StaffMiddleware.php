<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Staff ya Admin dono allowed hain (staff restricted pages ke liye)
        // Lekin yeh middleware un pages ke liye hai jo sirf logged-in user dekh sakta hai
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isStaff())) {
            return $next($request);
        }
        
        return redirect()->route('login');
    }
}
