<?php

$app_env = env('APP_ENV');
if ($app_env == 'staging') {
    $env = 'stg.';
} elseif ($app_env == 'local') {
    $env = 'local.';
} else {
    $env = '';
}

// Customer Web
Route::group(['domain' => $env . 'education-career.jp'], function () {
    // 求人
    Route::get('/', 'Customer\HomeController@index');
    Route::get('/search', 'Customer\HomeController@search');
    Route::get('/job', 'Customer\JobController@search');
    Route::post('/job', 'Customer\JobController@application');
    Route::get('/job/{job_id}/detail', ['as' => 'customer.job.detail', 'uses' => 'Customer\JobController@detail']);

    // 採用後担当者の方へ
    Route::get('/recruiter', 'Customer\ClientController@index');
    Route::get('/recruiter/entry', 'Customer\ClientController@entry');
    Route::get('/recruiter/completed', 'Customer\ClientController@completed');
    Route::post('/recruiter', 'Customer\ClientController@store');

    // 会員登録
    Route::get('/register', 'Customer\RegisterController@index');
    Route::get('/register/completed', 'Customer\RegisterController@completed');
    Route::get('/register/thanks', 'Customer\RegisterController@thanks');
    Route::post('/register', 'Customer\RegisterController@store');
    Route::get('/register/confirm/{token}', 'Customer\RegisterController@confirm');

    // アクティベーション
    Route::get('/register/re-activate', 'Customer\RegisterController@reactivate');
    Route::post('/register/re-activate', 'Customer\RegisterController@resend');

    // ログイン
    Route::get('/login', 'Customer\LoginController@index');
    Route::post('/login', 'Customer\LoginController@login');
    Route::post('/logout', 'Customer\LoginController@logout');

    // パスワード再発行
    Route::get('/password/reset', 'Customer\LoginController@reset_password');
    Route::post('/password/reset', 'Customer\LoginController@send_reset');
    Route::get('/password/confirm/{token}', 'Customer\LoginController@check_url');
    Route::post('/password/confirm', 'Customer\LoginController@confirm');

    // ソーシャルログイン
    Route::get('/auth/facebook', 'Customer\LoginController@facebookLogin');
    Route::get('/auth/facebook/callback', 'Customer\LoginController@facebookCallback');
    Route::get('/auth/google', 'Customer\LoginController@googleLogin');
    Route::get('/auth/google/callback', 'Customer\LoginController@googleCallback');

    // 静的ページ
    Route::get('/about', 'Customer\StaticController@educareer');
    Route::get('/terms', 'Customer\StaticController@terms');
    Route::get('/policy', 'Customer\StaticController@policy');
    Route::get('/contact', 'Customer\StaticController@contact');
    Route::post('/contact', 'Customer\StaticController@send');

    // エージェント相談
    Route::get('/agent/', 'Customer\AgentController@index');
    Route::post('/agent/', 'Customer\AgentController@store');
    Route::get('/agent/confirm/{token}', 'Customer\AgentController@confirm');
    Route::get('/agent/thanks', 'Customer\AgentController@thanks');

    // 求人応募
    Route::post('/application', 'Customer\ApplicationController@store');
    Route::get('/application/thanks', 'Customer\ApplicationController@thanks');

    // 認証領域
    Route::group(['middleware' => 'auth.customer'], function () {
        Route::get('/register/{customer_id}/profile', 'Customer\RegisterController@profile');
        Route::post('/register/{customer_id}/profile', 'Customer\RegisterController@storeProfile');

        Route::get('/mypage', 'Customer\MypageController@index');
        Route::get('/mypage/account', 'Customer\MypageController@editAccount');
        Route::put('/mypage/account', 'Customer\MypageController@updateAccount');
        Route::get('/mypage/profile', 'Customer\MypageController@editProfile');
        Route::put('/mypage/profile', 'Customer\MypageController@updateProfile');
        Route::get('/mypage/password', 'Customer\MypageController@editPassword');
        Route::put('/mypage/password', 'Customer\MypageController@updatePassword');
        Route::get('/mypage/quit', 'Customer\MypageController@indexQuit');
        Route::post('/mypage/quit', 'Customer\MypageController@quit');

        Route::get('/favorite', 'Customer\FavoriteController@index');
        Route::post('/favorite', 'Customer\FavoriteController@store');
        Route::delete('/favorite/{favorite_id}', 'Customer\FavoriteController@destroy');
    });

});

// Admin Panel
Route::group(['domain' => $env . 'admin.education-career.jp'], function () {
    // 非認証領域
    Route::get('/login', 'Admin\LoginController@index');
    Route::post('/login', 'Admin\LoginController@login');
    Route::get('/logout', 'Admin\LoginController@logout');
    Route::get('/reset_password', 'Admin\LoginController@resetPassword');
    Route::post('/reset_password', 'Admin\LoginController@sendResetMail');
    Route::get('/confirm/{token}', 'Admin\LoginController@checkUrl');
    Route::post('/confirm/', 'Admin\LoginController@confirm');

    // 管理者作成時のワンタイムURL確認ページ
    Route::get('/admin/confirm/{token}', 'Admin\AdminController@checkUrl');
    Route::post('/admin/confirm', 'Admin\AdminController@confirm');

    // クライアント担当者作成時のワンタイムURL確認ページ
    Route::get('/client_rep/confirm/{token}', 'Admin\ClientRepController@checkUrl');
    Route::post('/client_rep/confirm', 'Admin\ClientRepController@confirm');

    // 認証領域
    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('/', 'Admin\HomeController@index');
        Route::resource('admin', 'Admin\AdminController', ['except' => ['create', 'show']]);
        Route::resource('customer', 'Admin\CustomerController', ['except' => ['show']]);
        Route::resource('customer_profile', 'Admin\CustomerProfileController', ['only' => ['edit', 'update']]);
        Route::resource('client', 'Admin\ClientController', ['except' => ['show']]);
        Route::put('/client/{client_id}/permit', 'Admin\ClientController@permit');
        Route::resource('client_rep', 'Admin\ClientRepController', ['except' => ['create', 'show']]);
        Route::put('job/{job_id}/slide', 'Admin\JobController@update_slide');
        Route::put('job/{job_id}/pickup', 'Admin\JobController@update_pickup');
        Route::resource('job', 'Admin\JobController', ['except' => ['show']]);
        Route::post('/job/create', 'Admin\JobController@copy_and_create');
        Route::post('/job/franchise', 'Admin\JobController@store_franchise');
        Route::put('/job/{job_id}/franchise', 'Admin\JobController@update_franchise');
        Route::put('/job/{job_id}/publish', 'Admin\JobController@publish');
        Route::put('/job/{job_id}/depublish', 'Admin\JobController@depublish');
        Route::post('/preview', 'Admin\JobController@preview');
        Route::post('/preview/franchise', 'Admin\JobController@preview_franchise');
        Route::resource('upgrade', 'Admin\UpgradeController', ['only' => ['show', 'update', 'destroy']]);
        // /interview のresource()より上にしないと、PUT /interview/:something の方が優先される
        Route::put('/interview/order', 'Admin\InterviewArticleController@update_order');
        Route::resource('interview', 'Admin\InterviewArticleController', ['except' => ['show']]);
        Route::get('/ip', 'Admin\IpController@create');
        Route::post('/ip', 'Admin\IpController@store');
        Route::get('application/status/{status_id?}', 'Admin\ApplicationController@index');
        Route::get('/application/{app_id}', 'Admin\ApplicationController@show');
        Route::put('/application/{app_id}', 'Admin\ApplicationController@update');
        Route::get('/application', 'Admin\ApplicationController@index');
    });

});

// Client Admin Panel
Route::group(['domain' => $env . 'client.education-career.jp'], function () {
    // 非認証領域
    Route::get('/login', 'Client\LoginController@index');
    Route::post('/login', 'Client\LoginController@login');
    Route::get('/logout', 'Client\LoginController@logout');
    Route::get('/reset_password', 'Client\LoginController@resetPassword');
    Route::post('/reset_password', 'Client\LoginController@sendResetMail');
    Route::get('/confirm/{token}', 'Client\LoginController@checkUrl');
    Route::post('/confirm/', 'Client\LoginController@confirm');

    // クライアント担当者作成時のワンタイムURL確認ページ
    Route::get('/rep/confirm/{token}', 'Client\ClientRepController@checkUrl');
    Route::post('/rep/confirm', ['as' => 'client.confirm', 'uses' => 'Client\ClientRepController@confirm']);

    // 認証領域
    Route::group(['middleware' => 'auth.client'], function () {

        Route::get('/', 'Client\HomeController@index');
        Route::get('rep/password/{rep_id}', 'Client\ClientRepController@reset_password');
        Route::put('rep/password', 'Client\ClientRepController@update_password');
        Route::resource('rep', 'Client\ClientRepController', ['except' => ['create', 'show']]);
        Route::resource('company', 'Client\ClientController', ['only' => ['edit', 'update']]);
        Route::resource('posting', 'Client\JobController', ['except' => ['show']]);
        Route::post('/posting/create', 'Client\JobController@copy_and_create');
        Route::post('/posting/franchise', 'Client\JobController@store_franchise');
        Route::put('/posting/{job_id}/franchise', 'Client\JobController@update_franchise');
        Route::put('/posting/{job_id}/publish', 'Client\JobController@publish');
        Route::put('/posting/{job_id}/depublish', 'Client\JobController@depublish');
        Route::post('/preview', 'Client\JobController@preview');
        Route::post('/preview/franchise', 'Client\JobController@preview_franchise');
        Route::resource('upgrade', 'Client\UpgradeController', ['only' => ['index', 'store']]);

        Route::get('application/', 'Client\ApplicationController@index');
        Route::get('application/job/{job_id}', 'Client\ApplicationController@indexByJobId');
        Route::get('application/status/{status_id}', 'Client\ApplicationController@indexByStatusId');
        Route::get('application/job/{job_id}/status/{status_id}', 'Client\ApplicationController@indexByJobIdAndStatusId');

        Route::put('application/{app_id}', 'Client\ApplicationController@update');
        Route::put('application/{app_id}/rep/{rep_id}', 'Client\ApplicationController@updateRep');

        Route::get('application/{application_id}/check', 'Client\ApplicationController@show');

        Route::get('/api/posting/publish/{client_id}', 'Client\ApiController@shouldPublish');
        Route::get('/api/posting/upgrade/{client_id}', 'Client\ApiController@shouldUpgrade');
        Route::get('/api/application/check/{app_id}', 'Client\ApiController@canCheckDetail');
    });

});
