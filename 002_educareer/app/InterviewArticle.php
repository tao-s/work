<?php namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class InterviewArticle extends Model
{
    const TOP_PAGE_LIMIT = 5;

    protected $table = 'interview_articles';

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public static function relatedInterviews($client_id)
    {
        return self::with('client')
            ->where('client_id', $client_id)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();
    }

    public static function getForTopPage()
    {
        return self::with('client')
            ->whereNotNull('order')
            ->where('order', '<>', 0)
            ->orderBy('order', 'asc')
            ->take(self::TOP_PAGE_LIMIT)
            ->get();
    }

    /**
     * インタビュー記事の並び順を一括で変更する
     *
     * @param array $data キーが interview_articles.id 値が interview_articles.order の配列
     * @return bool
     */
    public static function updateOrder(array $data)
    {
        if (!$data) {
            return false;
        }

        $sql = 'UPDATE `interview_articles` SET `order` = :order WHERE `id` = :id';
        $stmt = DB::getPdo()->prepare($sql);

        return DB::transaction(function () use ($stmt, $data) {
            foreach ($data as $id => $order) {
                $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
                $stmt->bindValue(':order', $order, \PDO::PARAM_INT);

                if (!$stmt->execute()) {
                    return false;
                }
            }
            return true;
        });
    }
}
