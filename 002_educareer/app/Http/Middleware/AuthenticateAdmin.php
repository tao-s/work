<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;

class AuthenticateAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Auth::admin();

        if ($admin->guest()) {
            if ($request->ajax()) {

                return response('Unauthorized.', 401);

            } else {

                return redirect()->guest('/login');

            }
        }

        return $next($request);
    }

}
