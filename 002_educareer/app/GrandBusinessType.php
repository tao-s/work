<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GrandBusinessType extends Model {

    protected $table = 'grand_business_types';
    public $timestamps = false;

    public function business_types()
    {
        return $this->hasMany('App\BusinessType');
    }


}
