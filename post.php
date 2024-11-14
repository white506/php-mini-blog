<?php 
include 'db.php';

if (!isset($_GET['id'])) {
    die('Ошибка: не указан ID поста');
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die('Пост не найден');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        <div class="post-meta">Опубликовано: <?php echo $post['created_at']; ?></div>
        <div class="post-actions">
            <a href="edit.php?id=<?php echo $post['id']; ?> " class="btn edit">Редактировать</a> |
            <a href="delete.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить этот пост?')" class="btn delete">Удалить</a>
        </div>
        <a href="index.php" class="btn">Вернуться к списку постов</a> 
    </div>
</body>
</html>
