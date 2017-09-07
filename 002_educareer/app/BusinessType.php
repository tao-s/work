<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GrandBusinessType;

class BusinessType extends Model {

    protected $table = 'business_types';
    public $timestamps = false;

    public function grand_business_type()
    {
        return $this->belongsTo('App\GrandBusinessType');
    }


}
