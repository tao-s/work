<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;

class AuthenticateClient
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
        $client = Auth::client();

        if ($client->guest()) {
            if ($request->ajax()) {

                return response('Unauthorized.', 401);

            } else {

                return redirect()->guest('/login');

            }
        }

        return $next($request);
    }

}
