<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model {

    protected $table = 'ip_addresses';
    protected $fillable = ['ip'];

    public static function is_permitted($client_ip)
    {
        foreach (self::all() as $ip) {
            if ($ip->ip == $client_ip) {
                return true;
            }
        }

        return false;
    }

}
