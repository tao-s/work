<?php namespace App\Custom\Helper;

use Psy\Exception\RuntimeException;
use Request;

class ViewHelper
{

    public function active_class($module_key, $tag_key)
    {
        if ($module_key == $tag_key) {
            return 'active';
        }

        return '';
    }

    public function label($status)
    {
        $map = ['active' => 'primary', 'inactive' => 'warning'];

        if (!isset($map[$status])) {
            throw new RuntimeException();
        }

        return $map[$status];
    }

    public function selected($check, $against)
    {
        if ($check == $against) {
            return "selected";
        }

        return "";
    }

    /**
     * 現在のURLに応じたヘッダーのテキストを取得する
     *
     * @param string $company_name
     * @return string
     */
    public static function header_text($company_name = '')
    {
        if ($company_name) {
            return $company_name . 'の求人・採用・転職情報';
        }

        $dictionary = [
            '/' => '教育業界に特化した転職求人サービス',
            'job' => '教育業界の就職・転職に特化した求人サービス',
            'about' => '教育関係の仕事に特化した転職求人サービス',
            'recruiter' => '教育関係の求人広告掲載をお考えの採用担当者様へ',
        ];

        $path = Request::path();

        if (isset($dictionary[$path])) {
            return $dictionary[$path];
        } else {
            return '教育業界に特化した求人サービス';
        }
    }

    /**
     * 求人種別が選択されたものか調べる
     *
     * @param string $selected
     * @param string $current
     * @return string
     */
    public static function isSelectedCategory($selected, $current)
    {
        if (substr((string)$selected, 0, 1) === (string)$current) {
            return 'selected';
        } else {
            return '';
        }
    }
}