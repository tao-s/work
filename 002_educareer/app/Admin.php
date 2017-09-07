<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    protected $table = 'admins';

    // trait を使う。
    use Authenticatable;
    use CanResetPassword;

    public function status()
    {
        if ($this->password) {
            return 'active';
        }

        return 'inactive';
    }

    public static function getAllAdminEmails()
    {
        $admins = self::select('email')->where('email', '!=', 'root@education-career.jp')->get()->toArray();
        return array_pluck($admins, 'email');
    }

}