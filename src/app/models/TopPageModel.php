<?php

require_once __DIR__ . '/../core/Database.php';

class TopPageModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * 「今週の要注目」ドラマを取得する
     */
    public function getFeaturedWeeklyDramas() {
        $stmt = $this->pdo->query("SELECT id, title, broadcaster FROM dramas WHERE featured_weekly = true ORDER BY featured_priority DESC, id DESC");
        return $stmt->fetchAll();
    }

    /**
     * 「話題のドラマ」を取得する
     */
    public function getFeaturedPopularDramas() {
        $stmt = $this->pdo->query("SELECT id, title, broadcaster FROM dramas WHERE featured_popular = true ORDER BY featured_priority DESC, id DESC");
        return $stmt->fetchAll();
    }

    /**
     * 「最新の感想」を10件取得する
     */
    public function getLatestReviews() {
        $stmt = $this->pdo->query("
            SELECT 
                r.id, 
                r.nickname, 
                r.rating, 
                r.comment, 
                d.title as drama_title
            FROM reviews r
            JOIN dramas d ON r.drama_id = d.id
            ORDER BY r.created_at DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    /**
     * 放送中のドラマを曜日別に取得する
     * @return array 曜日をキーとしたドラマの配列
     */
    public function getAiringDramasGroupedByDay() {
        $stmt = $this->pdo->query("
            SELECT id, title, broadcaster, timeslot, air_day
            FROM dramas
            WHERE status = 'airing'
            ORDER BY FIELD(air_day, '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日'), timeslot
        ");
        $dramas = $stmt->fetchAll();

        $groupedDramas = [];
        foreach ($dramas as $drama) {
            $groupedDramas[$drama['air_day']][] = $drama;
        }
        return $groupedDramas;
    }
}