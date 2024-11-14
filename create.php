<?php 
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Создать новый пост</title>
</head>
<body>
    <div class="container">
        <h1>Создать новый пост</h1>
        <form action="create.php" method="POST">
            <label for="title">Заголовок:</label>
            <input type="text" name="title" required>
            
            <label for="content">Контент:</label>
            <textarea name="content" required></textarea>
            
            <button type="submit">Создать пост</button>
            <a href="index.php" class="btn">Вернуться к списку постов</a> 
        </form>
    </div>
</body>
</html>
