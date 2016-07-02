<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Maintenance extends CheckForMaintenanceMode
{
    public function handle($request, Closure $next)
    {
        if ($request->is(config('app.admin_route_name') . '/*') || $request->is(config('app.admin_route_name'))) {
            $admin = true;
        } else {
            $admin = false;
        }
        if ($this->app->isDownForMaintenance() && !$admin) {
            throw new HttpException(503);
        }

        return $next($request);
    }

}
