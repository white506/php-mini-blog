<?php 
include 'db.php';

if (!isset($_GET['id'])) {
    die('Ошибка: не указан ID поста');
}

$id = $_GET['id'];

// Удаляем пост
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location: index.php"); // Перенаправляем на главную страницу
?>
