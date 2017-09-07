<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolRecord extends Model {

    protected $table = 'school_records';
    protected $fillable = ['id', 'title'];
    public $timestamps = false;

}
