<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {

    public $timestamps = false;

    public function prefectures()
    {
        return $this->hasMany('App\Prefecture')->orderBy('sort');
    }

}
