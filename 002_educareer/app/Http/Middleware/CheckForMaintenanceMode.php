<?php namespace App\Http\Middleware;

use Closure;
use App\IpAddress;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckForMaintenanceMode implements Middleware {

    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new filter instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // .envで挙動を決めよ。
        if ($this->app->isDownForMaintenance())
        {
            if (IpAddress::is_permitted($request->ip())) {
                return $next($request);
            }

            // customerのみメンテナンス
            if (env('APP_MAINTENANCE_MODE') == 'customer') {
                // clientとadminは回避させる
                if (strpos($request->root(), 'admin.education-career.jp') || strpos($request->root(), 'client.education-career.jp')) {
                    return $next($request);
                }
            }

            // customerとclientのみメンテナンス
            if (env('APP_MAINTENANCE_MODE') == 'customer|client') {
                // adminは回避させる
                if (strpos($request->root(), 'admin.education-career.jp')) {
                    return $next($request);
                }
            }

            throw new HttpException(503);
        }

        return $next($request);
    }

}
