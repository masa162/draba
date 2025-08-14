<?php
// CSVデータをDBに投入するスクリプト
// 使い方: docker-compose exec app php /scripts/import_dramas.php [CSVファイルのパス]

require_once '/var/www/html/app/core/Database.php';

if ($argc < 2) {
    echo "エラー: CSVファイルのパスを指定してください。\n";
    exit(1);
}

$csvFilePath = $argv[1];
if (!file_exists($csvFilePath)) {
    echo "エラー: ファイルが見つかりません: $csvFilePath\n";
    exit(1);
}

$pdo = Database::getInstance()->getConnection();

// DBをクリーンアップ（テスト用 - 必要に応じてコメントアウトを外してください）
// $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
// $pdo->exec("TRUNCATE TABLE likes");
// $pdo->exec("TRUNCATE TABLE reviews");
// $pdo->exec("TRUNCATE TABLE dramas");
// $pdo->exec("SET FOREIGN_KEY_CHECKS=1");

$handle = fopen($csvFilePath, "r");
if ($handle === false) {
    echo "エラー: ファイルを開けません: $csvFilePath\n";
    exit(1);
}

$header = fgetcsv($handle); // ヘッダー行を読み込む

$insertedDramaCount = 0;
$updatedDramaCount = 0;
$insertedReviewCount = 0;

while (($row = fgetcsv($handle)) !== false) {

    // CSVの行を連想配列に変換
    if (count($header) !== count($row)) continue;
    $data = array_combine($header, $row);

    // --- データ変換・クレンジング ---
    $season_map = ['1月期' => 'winter', '4月期' => 'spring', '6月期' => 'summer', '7月期' => 'summer', '8月期' => 'summer', '10月期' => 'autumn'];
    $season = $season_map[$data['season']] ?? null;

    $status = str_replace('cmpleted', 'completed', $data['status']);

    // featured_weekly, featured_popular の設定 (テスト用ロジック)
    $featured_weekly_int = 0;
    $featured_popular_int = 0;
    if ($insertedDramaCount < 5) { // 最初の5件を要注目に
        $featured_weekly_int = 1;
    } elseif ($insertedDramaCount >= 5 && $insertedDramaCount < 10) { // 次の5件を話題に
        $featured_popular_int = 1;
    }

    // --- UPSERT (UPDATE or INSERT) for dramas ---
    try {
        $stmt = $pdo->prepare("SELECT id FROM dramas WHERE title = ?");
        $stmt->execute([$data['title']]);
        $existingDramaId = $stmt->fetchColumn();

        if ($existingDramaId) {
            // UPDATE
            $sql = "UPDATE dramas SET broadcaster=?, timeslot=?, air_day=?, `year`=?, season=?, status=?, genre=?, main_cast=?, synopsis=?, featured_weekly=?, featured_popular=? WHERE id=?";
            $params = [
                $data['broadcaster'], $data['timeslot'], $data['air_day'], $data['year'], $season, $status,
                $data['genre'], $data['main_cast'], $data['あらすじ'], $featured_weekly_int, $featured_popular_int, $existingDramaId
            ];
            $pdo->prepare($sql)->execute($params);
            $updatedDramaCount++;
            $currentDramaId = $existingDramaId;
        } else {
            // INSERT
            $sql = "INSERT INTO dramas (title, broadcaster, timeslot, air_day, `year`, season, status, genre, main_cast, synopsis, featured_weekly, featured_popular) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = [
                $data['title'], $data['broadcaster'], $data['timeslot'], $data['air_day'], $data['year'], $season, $status,
                $data['genre'], $data['main_cast'], $data['あらすじ'], $featured_weekly_int, $featured_popular_int
            ];
            $pdo->prepare($sql)->execute($params);
            $insertedDramaCount++;
            $currentDramaId = $pdo->lastInsertId(); // 新規挿入されたIDを取得
        }

        // --- レビューデータの投入 (テスト用) ---
        if ($currentDramaId && $insertedReviewCount < 20) { // 最大20件のレビューを投入
            $reviewCountForDrama = rand(1, 3); // 1ドラマにつき1〜3件のレビュー
            for ($i = 0; $i < $reviewCountForDrama; $i++) {
                $reviewId = uniqid(); // ユニークなIDを生成
                $nickname = "名無しさん" . rand(1, 100);
                $rating = rand(1, 5);
                $comment = "このドラマはとても面白かったです！(" . $data['title'] . ")";
                if ($i == 1) $comment = "期待通りの内容でした。";
                if ($i == 2) $comment = "もう少し頑張ってほしいです。";

                $sqlReview = "INSERT INTO reviews (id, drama_id, nickname, rating, comment) VALUES (?, ?, ?, ?, ?)";
                $paramsReview = [$reviewId, $currentDramaId, $nickname, $rating, $comment];
                $pdo->prepare($sqlReview)->execute($paramsReview);
                $insertedReviewCount++;
            }
        }

    } catch (PDOException $e) {
        echo "DBエラー: " . $e->getMessage() . "\n";
        echo "対象データ: " . $data['title'] . "\n";
    }
}

echo "処理が完了しました。\n";
echo "新規追加ドラマ: $insertedDramaCount 件\n";
echo "更新ドラマ: $updatedDramaCount 件\n";
echo "新規追加レビュー: $insertedReviewCount 件\n";

// --- デバッグ用: dramasテーブルの件数確認 ---
echo "\n--- DB確認 ---\n";
$stmt = $pdo->query("SELECT COUNT(*) FROM dramas");
echo "dramasテーブルの件数: " . $stmt->fetchColumn() . "件\n";
$stmt = $pdo->query("SELECT COUNT(*) FROM reviews");
echo "reviewsテーブルの件数: " . $stmt->fetchColumn() . "件\n";
echo "----------------\n";