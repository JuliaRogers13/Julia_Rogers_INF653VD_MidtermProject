<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

try {

    $stmt = $conn->prepare("INSERT INTO quotes (quote, author_id, category_id) 
                            VALUES (:quote, :author_id, :category_id) 
                            RETURNING id");
    $stmt->bindParam(':quote', $data->quote);
    $stmt->bindParam(':author_id', $data->author_id);
    $stmt->bindParam(':category_id', $data->category_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode([
        'id' => $result['id'],
        'quote' => $data->quote,
        'author_id' => $data->author_id,
        'category_id' => $data->category_id
    ]);
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
