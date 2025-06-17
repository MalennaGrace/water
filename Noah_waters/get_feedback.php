<?php
require 'config.php';

header('Content-Type: application/json');

try {
    // Get average rating
    $avg_sql = "SELECT AVG(rating) as average_rating, COUNT(*) as total_ratings 
                FROM feedback 
                WHERE status = 'approved'";
    $avg_result = $conn->query($avg_sql);
    $avg_data = $avg_result->fetch_assoc();
    
    // Get approved feedback
    $sql = "SELECT name, rating, message, created_at 
            FROM feedback 
            WHERE status = 'approved' 
            ORDER BY created_at DESC 
            LIMIT 10";
            
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception('Database error: ' . $conn->error);
    }

    $feedback = [];
    while ($row = $result->fetch_assoc()) {
        $feedback[] = [
            'name' => htmlspecialchars($row['name']),
            'rating' => (int)$row['rating'],
            'message' => htmlspecialchars($row['message']),
            'date' => date('F j, Y', strtotime($row['created_at']))
        ];
    }

    echo json_encode([
        'success' => true,
        'average_rating' => round($avg_data['average_rating'], 1),
        'total_ratings' => (int)$avg_data['total_ratings'],
        'feedback' => $feedback
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 