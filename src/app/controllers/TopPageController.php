<?php

require_once __DIR__ . '/../models/TopPageModel.php';

class TopPageController {
    public function index() {
        $model = new TopPageModel();
        
        $data = [
            'weeklyDramas' => $model->getFeaturedWeeklyDramas(),
            'popularDramas' => $model->getFeaturedPopularDramas(),
            'latestReviews' => $model->getLatestReviews(),
            'airingDramas' => $model->getAiringDramasGroupedByDay() // 追加
        ];

        // データをビューに渡して表示
        require_once __DIR__ . '/../views/top.php';
    }
}
