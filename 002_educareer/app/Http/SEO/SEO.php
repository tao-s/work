<?php namespace App\Http\SEO;

use Session;
use Illuminate\Http\Request;

abstract class SEO
{
    protected $title = '';
    protected $description = '';
    protected $keywords = '';

    protected abstract function set_title();
    protected abstract function set_description();
    protected abstract function set_keywords();
    protected abstract function configure();

    const BASE_TITLE = '教育業界に特化した就職・転職の求人サービス【Education Career】';

    /**
     * @param Request $req
     */
    public function __construct(Request $req)
    {
        $this->req = $req;
        $this->configure();
        $this->set_title();
        $this->set_description();
        $this->set_keywords();
    }

    public function title()
    {
        return $this->title;
    }

    public function description()
    {
        return $this->description;
    }

    public function keywords()
    {
        return $this->keywords;
    }

}