<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,$role): Response
    {

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // إذا لم يكن له الدور المناسب
        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    
}

}
