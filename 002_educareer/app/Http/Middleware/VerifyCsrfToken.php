<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends BaseVerifier
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
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            Session::regenerateToken();
            return redirect()->back()
                ->withInput()
                ->withErrors('不正なセキュリティートークンが検出されました。');
        }
    }

}
