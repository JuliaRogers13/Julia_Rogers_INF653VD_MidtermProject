<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

try {
    $stmt = $conn->prepare("UPDATE quotes 
                            SET quote = :quote, author_id = :author_id, category_id = :category_id 
                            WHERE id = :id");
    $stmt->bindParam(':quote', $data->quote);
    $stmt->bindParam(':author_id', $data->author_id);
    $stmt->bindParam(':category_id', $data->category_id);
    $stmt->bindParam(':id', $data->id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'id' => $data->id,
            'quote' => $data->quote,
            'author_id' => $data->author_id,
            'category_id' => $data->category_id
        ]);
    } else {
        echo json_encode(['message' => 'No Quotes Found']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}