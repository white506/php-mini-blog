<?php 
include 'db.php';

$posts_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $posts_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT COUNT(*) FROM posts");
$total_posts = $stmt->fetchColumn();
$total_pages = ceil($total_posts / $posts_per_page);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Блог</title>
</head>
<body>
    <div class="container">
        <h1>Мой Блог</h1>
        <a href="create.php" class="btn">Создать новый пост</a>

        <?php foreach ($posts as $post): ?>
            <div class="post-preview">
                <h2><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h2>
                <p><?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></p>
                <div class="post-meta">Опубликовано: <?php echo $post['created_at']; ?></div>
                <div class="post-actions">
                    <a href="edit.php?id=<?php echo $post['id']; ?> " class="btn edit">Редактировать</a> |
                    <a href="delete.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить этот пост?')" class="btn delete">Удалить</a>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Предыдущая</a>
            <?php endif; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Следующая</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
