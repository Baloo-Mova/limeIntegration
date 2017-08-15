<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotAllData
{

    public $availableRoutes = [
        'account.update',
        'account.edit'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (in_array($request->route()->action['as'], $this->availableRoutes)) {
            return $next($request);
        }

        if (Auth::check() && !Auth::user()->checkFullData()) {
            return redirect(route('account.edit'))->withErrors(['needFull' => true]);
        }

        return $next($request);
    }
}
