<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model {

    protected $table = 'application_statuses';
    public $timestamps = false;

    const StatusUndecided = 1;
    const StatusPending = 2;
    const StatusContacted = 3;
    const StatusDeclined = 4;
    const StatusOffered = 5;

}
