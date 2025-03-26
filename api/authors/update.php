<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->author)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

try {
    $stmt = $conn->prepare("UPDATE authors SET author = :author WHERE id = :id");
    $stmt->bindParam(':author', $data->author);
    $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'id' => $data->id,
            'author' => $data->author
        ]);
    } else {
        echo json_encode(['message' => 'author_id Not Found']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
?>
