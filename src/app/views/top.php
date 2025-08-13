<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="main-wrapper">
    <aside class="sidebar">
        <h2>放送中のドラマ</h2>
        <?php foreach (['月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日'] as $day): ?>
            <?php if (isset($data['airingDramas'][$day]) && !empty($data['airingDramas'][$day])): ?>
                <h3><?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></h3>
                <ul>
                    <?php foreach ($data['airingDramas'][$day] as $drama): ?>
                        <li>
                            <?php echo htmlspecialchars(substr($drama['timeslot'], 0, 5), ENT_QUOTES, 'UTF-8'); ?>
                            <a href="/drama.php?id=<?php echo htmlspecialchars($drama['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars(mb_strimwidth($drama['title'], 0, 20, '...', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endforeach; ?>
    </aside>

    <main class="main-content">
        <h2>今週の要注目</h2>
        <ul>
            <?php foreach ($data['weeklyDramas'] as $drama): ?>
                <li>
                    <a href="/drama.php?id=<?php echo htmlspecialchars($drama['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($drama['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    (<?php echo htmlspecialchars($drama['broadcaster'], ENT_QUOTES, 'UTF-8'); ?>)
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>話題のドラマ</h2>
        <ul>
            <?php foreach ($data['popularDramas'] as $drama): ?>
                <li>
                    <a href="/drama.php?id=<?php echo htmlspecialchars($drama['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($drama['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    (<?php echo htmlspecialchars($drama['broadcaster'], ENT_QUOTES, 'UTF-8'); ?>)
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>最新の感想</h2>
        <ul>
            <?php foreach ($data['latestReviews'] as $review): ?>
                <li>
                    <strong><?php echo htmlspecialchars($review['nickname'], ENT_QUOTES, 'UTF-8'); ?>さん:</strong>
                    「<?php echo htmlspecialchars($review['comment'], ENT_QUOTES, 'UTF-8'); ?>」
                    (<?php echo htmlspecialchars($review['drama_title'], ENT_QUOTES, 'UTF-8'); ?>)
                    - ★<?php echo htmlspecialchars($review['rating'], ENT_QUOTES, 'UTF-8'); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>