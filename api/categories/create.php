<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->category)) {
    echo json_encode(['message' => 'Missing Required Parameter: category']);
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO categories (category) VALUES (:category) RETURNING id");
    $stmt->bindParam(':category', $data->category);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode([
        'id' => $result['id'],
        'category' => $data->category
    ]);
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
