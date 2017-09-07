<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class CustomerConfirmation extends Model {

    protected $table = 'customer_confirmations';

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function saveWithOnetimeUrl()
    {
        $this->token_generated_at = Carbon::now('jst');
        $this->confirmation_token = sha1(uniqid(mt_rand(), true));

        if (!$this->save()) {
            throw new RuntimeException;
        }
    }

    public function scopeValidUrl($query, $token)
    {
        return $query->where('token_generated_at', '>', Carbon::now()->subHours(24))
            ->where('confirmation_token', $token)
            ->where('confirmed_at', null);
    }


}
