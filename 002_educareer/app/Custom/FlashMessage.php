<?php namespace App\Custom;


class FlashMessage
{

    protected $type;
    protected $message;


    public function __construct($type = '', $message = '')
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function type($type = null)
    {
        if ($type == null) {
            return $this->type;
        }

        $this->type = $type;
        return;
    }

    public function message($message = null)
    {
        if ($message == null) {
            return $this->message;
        }

        $this->message = $message;
        return;
    }

}