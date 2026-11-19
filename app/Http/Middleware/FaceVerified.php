<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FaceVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'mahasiswa' && ! $request->session()->get('face_verified')) {
            return redirect()->route($user->mahasiswa?->face_descriptor ? 'face.verify' : 'face.enroll');
        }

        return $next($request);
    }
}