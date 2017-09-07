<?php namespace App\Custom\Facades;

use Illuminate\Support\Facades\Facade;

class ViewHelper extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'viewHelper';
    }

}
