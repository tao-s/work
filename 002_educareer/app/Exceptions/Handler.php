<?php namespace App\Exceptions;

use Auth;
use Exception;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Maknz\Slack\Client;
use Symfony\Component\Debug\ExceptionHandler as SymfonyDisplayer;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return
     */
    public function report(Exception $e)
    {
        if (!env('SLACK_ON')) {
            return parent::report($e);
        }

        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            if ($code == '404' || $code = '503') {
                return parent::report($e);
            }
        }

        $req = Request::capture();
        $app_name = '';
        $user_id = 'no-user';
        $url = $req->url();
        if (strpos($url, 'admin.education-career.jp'))
        {
            $client = new Client(env('SLACK_TO_ADMIN'));
            $app_name = 'Admin';

            if ($user = Auth::admin()->get()) {
                $user_id = $user->id;
            }

        }
        elseif (strpos($url, 'client.education-career.jp'))
        {
            $client = new Client(env('SLACK_TO_CLIENT'));
            $app_name = 'Client';
            if ($user = Auth::client()->get()) {
                $user_id = $user->id;
            }

        }
        else
        {
            $client = new Client(env('SLACK_TO_CUSTOMER'));
            $app_name = 'Customer';

            if ($user = Auth::customer()->get()) {
                $user_id = $user->id;
            }
        }

        $client->attach([
            'fallback' => '',
            'color' => '#F35A00',
            'fields' => [
                [
                    'title' => 'Application',
                    'value' => $app_name,
                ],
                [
                    'title' => 'URL',
                    'value' => $req->url(),
                ],
                [
                    'title' => 'Method',
                    'value' => $req->method(),
                ],
                [
                    'title' => 'Login User Id',
                    'value' => $user_id,
                ],
                [
                    'title' => 'Message',
                    'value' => $e->getMessage(),
                ],
                [
                    'title' => 'Line',
                    'value' => $e->getLine(),
                ],
                [
                    'title' => 'File',
                    'value' => $e->getFile(),
                ]
            ]
        ])->send("Error on '{$app_name}' by the user: {$user_id}");
//        $client->send('```'.$e->getTraceAsString().'```');

        return parent::report($e);
    }

    /**
     * admin, client, customerの404ページの出し分け処理
     *
     * @param HttpException $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();
        $template_prefix = 'pc';
        $agent = new Agent();
        if ($agent->isMobile()) {
            // 2015-10-30にスマホ対応をリリースするまではPC画面を表示
            $template_prefix = 'mobile';
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $status = '404';
        }

        $url = Request::capture()->url();
        if (strpos($url, 'admin.education-career.jp'))
        {
            $template = "errors.admin.{$status}";
            if (view()->exists($template)) {
                return response()->view($template, [], $status);
            }
        }
        elseif (strpos($url, 'client.education-career.jp'))
        {
            $template = "errors.client.{$status}";
            if (view()->exists($template)) {
                return response()->view($template, [], $status);
            }
        }
        else
        {
            if ($user = Auth::customer()->get()) {
                $user->load('profile');
            }

            $template = "errors.customer.{$template_prefix}.{$status}";
            if (view()->exists($template)) {
                return response()->view($template, ['user' => $user], $status);
            }
        }

        return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($req, Exception $e)
    {
        if (env('APP_DEBUG')) {
            return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
        }

        if ($e instanceof HttpException) {
            return parent::render($req, $e);
        }

        $template_prefix = 'pc';
        $agent = new Agent();
        if ($agent->isMobile()) {
            // 2015-10-30にスマホ対応をリリースするまではPC画面を表示
            $template_prefix = 'mobile';
        }
        $url = $req->url();
        if (strpos($url, 'admin.education-career.jp'))
        {
            return response()->view("errors.admin.500", [], '500');
        }
        elseif (strpos($url, 'client.education-career.jp'))
        {
            return response()->view("errors.client.500", [], '500');
        }
        else
        {
            if ($user = Auth::customer()->get()) {
                $user->load('profile');
            }
            return response()->view("errors.customer.{$template_prefix}.500", ['user' => $user], '500');
        }
    }

}
