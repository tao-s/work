<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class ClientRep extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    protected $table = 'client_reps';

    // trait を使う。
    use Authenticatable;
    use CanResetPassword;

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function applications()
    {
        $this->hasMany(Application::class);
    }

    public function status()
    {
        if ($this->password) {
            return 'active';
        }

        return 'inactive';
    }

    public static function getAllRepEmails($client_id)
    {
        $reps = self::select('email')->where('client_id', $client_id)->get()->toArray();
        return array_pluck($reps, 'email');
    }

    /**
     * 担当者名又はemailを取得する
     *
     * @param int|null $limit 表示する文字数の上限 nullの場合は無制限
     * @return string
     */
    public function getNameOrEmail($limit = null)
    {
        if ($this->name) {
            $str = $this->name;
        } else {
            $str = $this->email;
        }

        if (!is_null($limit) && mb_strlen($str) > $limit) {
            return mb_substr($str, 0, $limit) . '…';
        }

        return $str;
    }
}
