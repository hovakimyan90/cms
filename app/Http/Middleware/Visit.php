<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;

class Visit
{
    /**
     * Handle an incoming request
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->get('site_visit')) {
            $visit = new SiteVisit();
            $visit->save();
            session(['site_visit' => 'true']);
        }
        return $next($request);
    }
}
