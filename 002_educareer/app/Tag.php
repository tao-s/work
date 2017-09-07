<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $table = 'tags';
    public $timestamps = false;

    public function jobs()
    {
        return $this->belongsToMany('App\Job');
    }

}
