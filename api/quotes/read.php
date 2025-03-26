<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->connect();

// Get query parameters (if any)
$id = isset($_GET['id']) ? $_GET['id'] : null;
$author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

try {
    if ($id) {
        // Retrieve a specific quote by id
        $stmt = $conn->prepare("SELECT quotes.id, quotes.quote, authors.author, categories.category
                                FROM quotes
                                JOIN authors ON quotes.author_id = authors.id
                                JOIN categories ON quotes.category_id = categories.id
                                WHERE quotes.id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } elseif ($author_id || $category_id) {
        // Build a query based on provided author_id or category_id
        $query = "SELECT quotes.id, quotes.quote, authors.author, categories.category
                  FROM quotes
                  JOIN authors ON quotes.author_id = authors.id
                  JOIN categories ON quotes.category_id = categories.id
                  WHERE 1=1";
        if ($author_id) {
            $query .= " AND quotes.author_id = :author_id";
        }
        if ($category_id) {
            $query .= " AND quotes.category_id = :category_id";
        }
        $stmt = $conn->prepare($query);
        if ($author_id) {
            $stmt->bindParam(':author_id', $author_id);
        }
        if ($category_id) {
            $stmt->bindParam(':category_id', $category_id);
        }
        $stmt->execute();
    } else {
        // Retrieve all quotes
        $stmt = $conn->query("SELECT quotes.id, quotes.quote, authors.author, categories.category
                              FROM quotes
                              JOIN authors ON quotes.author_id = authors.id
                              JOIN categories ON quotes.category_id = categories.id");
    }
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(['message' => 'No Quotes Found']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
?>
