<?php
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class EducationCareerFilters extends \Twig_Extension
{

    public function getName()
    {
        return 'EducationCareer Filters';
    }

    public function getFilters()
    {
        $filters = [
            'dump',
            'word_limit',
            'strip_html',
        ];

        $ret = [];
        foreach ($filters as $filter_name) {
            $ret[$filter_name] = new \Twig_Filter_Method($this, $filter_name);
        }

        return $ret;
    }

    public function word_limit($string, $limit, $trailer)
    {
        $truncated = $string;
        if (strlen($string) > $limit) {
            $truncated = mb_substr($string, 0, $limit) . $trailer;
        }

        return $truncated;
    }

    public function strip_html($body)
    {
        $striped = strip_tags($body);
        return $striped;
    }

    public function dump($variable, $max_data = 1024, $exit = false)
    {
        ini_set('xdebug.var_display_max_data', $max_data);
        var_dump($variable);
        if ($exit) {
            exit;
        }
    }
}