<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For now, we'll assume admin access is based on a specific user
        // In the future, you can implement proper role-based access control
        
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        }

        // Check if user is admin (you can modify this logic based on your requirements)
        // For now, we'll check if it's a User model (admin) vs Customer model
        if (!($user instanceof \App\Models\User)) {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required'
            ], 403);
        }

        return $next($request);
    }
}