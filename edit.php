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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: post.php?id=$id");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Редактировать пост</title>
</head>
<body>
    <div class="container">
        <h1>Редактировать пост</h1>
        <form action="edit.php?id=<?php echo $post['id']; ?>" method="POST">
            <label for="title">Заголовок:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            
            <label for="content">Контент:</label>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            
            <button type="submit">Сохранить изменения</button>

            <a href="index.php" class="btn">Отменить изменения</a> 
        </form>
    </div>
</body>
</html>
