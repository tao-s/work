<?php namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ApplicationCheck extends Model {

    protected $table = 'application_checks';

    public function application()
    {
        return $this->belongsTo('App\Application');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public static function count(Application $app)
    {
        if (self::where('application_id', $app->id)->count() == 0) {
            $app_check = new self();
            $app_check->client_id = Auth::client()->get()->client_id;
            $app_check->application_id = $app->id;
            $app_check->save();
        }
    }

}
