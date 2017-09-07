<?php namespace App\Http\Middleware;

use Session;
use Closure;

class SetRedirectPath
{

    /**
     * ログイン後直前のGETリクエストにリダイレクトするための処理
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($req, Closure $next)
    {
        $black_list = collect([
            'login',
            'auth/facebook',
            'auth/facebook/callback',
            'auth/google',
            'auth/google/callback'
        ]);

        if ($req->method() == 'GET' && !$black_list->contains($req->path())) {
            Session::put('last_get_request', $req->getRequestUri());
        }

        return $next($req);
    }

}
