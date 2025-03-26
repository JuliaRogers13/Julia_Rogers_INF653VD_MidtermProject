<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->author)) {
    echo json_encode(['message' => 'Missing Required Parameter: author']);
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO authors (author) VALUES (:author) RETURNING id");
    $stmt->bindParam(':author', $data->author);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode([
        'id' => $result['id'],
        'author' => $data->author
    ]);
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
?>
