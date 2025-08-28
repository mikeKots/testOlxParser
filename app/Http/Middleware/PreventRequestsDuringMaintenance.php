<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Request;

class PreventRequestsDuringMaintenance
{
    public function handle(Request $request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            throw new MaintenanceModeException(
                now(), // час початку
                []     // додаткові опції
            );
        }

        return $next($request);
    }
}
