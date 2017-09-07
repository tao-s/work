<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model {

    protected $table = 'plans';
    const EndOfJan = 1;
    const SixMonths = 2;
    const OneYear = 3;

    /**
     * @return string|null
     */
    public function getExpireDate()
    {
        if ($this->plan_months) {
            $interval = \DateInterval::createFromDateString($this->plan_months . ' month');

            return (new \DateTime())->add($interval)->format('Y-m-d');
        } else {
            return null;
        }
    }
}
