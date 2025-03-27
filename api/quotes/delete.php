<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    echo json_encode(['message' => 'Missing Required Parameter: id']);
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM quotes WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['id' => $id, 'message' => 'Deleted successfully']);
    } else {
        echo json_encode(['message' => 'No Quotes Found']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}