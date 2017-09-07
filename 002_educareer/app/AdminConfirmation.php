<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Psy\Exception\RuntimeException;

class AdminConfirmation extends Model
{

    protected $table = 'admin_confirmations';

    public function setOnetimeUrl()
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
