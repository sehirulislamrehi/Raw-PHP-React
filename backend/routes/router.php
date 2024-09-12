<?php

// Enable CORS headers
header('Access-Control-Allow-Origin: *'); // Allow requests only from this origin
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Allowed HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allowed headers

// Handle preflight requests (OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Font;
use App\Repositories\FontRepository;

$font_repository = new FontRepository();
$fontController = new Font($font_repository);


if (isset($_GET['dispatch'])) {

    $method = isset(explode(".",$_GET['dispatch'])[1]) ? explode(".",$_GET['dispatch'])[1] : null;

    switch ($method) {
        
        case 'index':
            $response = $fontController->index(); // Get the response data
            sendJsonResponse(200, $response); // Send JSON response
            break;

        case 'create':
            $response = $fontController->create(); // Get the response data
            sendJsonResponse(200, $response); // Send JSON response
            break;

        case 'delete':
            $response = $fontController->delete(); // Get the response data
            sendJsonResponse(200, $response); // Send JSON response
            break;

        default:
            http_response_code(405);
            echo json_encode(['message' => 'Method not found']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not found']);
}


// Helper function to send JSON response
function sendJsonResponse($statusCode, $data) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
}