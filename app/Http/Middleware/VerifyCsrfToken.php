<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/login',
//        "api/*"
    ];

    protected function shouldPassThrough($request)
    {
        return $request->is('swagger/*'); // Adjust the path according to your Swagger routes
    }
}
