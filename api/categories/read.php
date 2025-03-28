<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

$id = isset($_GET['id']) ? $_GET['id'] : null;

try {
    if ($id) {
        $stmt = $conn->prepare("SELECT id, category FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $conn->query("SELECT id, category FROM categories");
    }
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($data && count($data) > 0) {
        echo json_encode($data);
    } else {
        echo json_encode(['message' => 'category_id Not Found']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
