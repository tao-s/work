<?php namespace App\Custom\Helper;

use Illuminate\Support\ServiceProvider;

class ViewHelperServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->bind('viewHelper', 'App\Custom\Helper\ViewHelper');
    }

}
