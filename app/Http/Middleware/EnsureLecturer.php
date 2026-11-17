<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLecturer
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->isLecturer(), 403, 'Halaman ini hanya untuk dosen.');

        return $next($request);
    }
}
