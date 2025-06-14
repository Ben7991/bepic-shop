<?php

namespace App\Http\Middleware;

use App\Utils\Enum\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsDistributor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role !== Role::DISTRIBUTOR->name) {
            return redirect()->back();
        }

        return $next($request);
    }
}
