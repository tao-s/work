<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OccupationCategory extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'name'];

    const ID_OTHERS = 80; // 「その他」

    /**
     * @param string
     * @return string
     */
    public function nameWithParentCategory($free_word)
    {
        $dict = [
            '1' => '営業職',
            '2' => '企画・管理系職種',
            '3' => 'エンジニア・技術系職種',
            '4' => 'クリエイティブ・クリエイター系職種',
            '5' => '講師・教員関連職種',
            '6' => '専門職種（コンサルタント、士業系等）',
            '7' => '事務系職種',
            '8' => 'その他',
        ];

        $firstLetter = substr($this->id, 0, 1);

        if (isset($dict[$firstLetter])) {
            if ($firstLetter === '8') {
                return $dict[$firstLetter] . '：' . $free_word;
            } else {
                return $dict[$firstLetter] . '：' . $this->name;
            }
        } else {
            return '';
        }
    }
}
