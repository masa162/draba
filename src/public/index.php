<?php

require_once __DIR__ . '/../app/controllers/TopPageController.php';

// シンプルなルーティング
// 今はトップページしかないので、常にTopPageControllerを呼び出す
$controller = new TopPageController();
$controller->index();