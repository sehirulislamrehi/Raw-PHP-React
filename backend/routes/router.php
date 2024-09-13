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
require_once __DIR__ . '/../config.php';

use App\Controllers\Font;
use App\Controllers\FontGroup;
use App\Repositories\Font\ReadFontRepository;
use App\Repositories\Font\WriteFontRepository;
use App\Repositories\FontGroup\ReadFontGroupRepository;
use App\Repositories\FontGroup\WriteFontGroupRepository;

if (isset($_GET['dispatch'])) {

    $controller = isset(explode(".",$_GET['dispatch'])[0]) ? explode(".",$_GET['dispatch'])[0] : "";
    $method = isset(explode(".",$_GET['dispatch'])[1]) ? explode(".",$_GET['dispatch'])[1] : "";

    switch ($controller) {
        
        case 'Font':

            $readFontRepository = new ReadFontRepository($conn);
            $writeFontRepository = new WriteFontRepository($conn);
            $fontController = new Font($readFontRepository,$writeFontRepository);

            switch($method){
                
                case 'index':
                    $response = $fontController->index(); 
                    sendJsonResponse(200, $response); 
                    break;
        
                case 'create':
                    $response = $fontController->create(); 
                    sendJsonResponse(200, $response); 
                    break;
        
                case 'delete':
                    $response = $fontController->delete(); 
                    sendJsonResponse(200, $response); 
                    break;
        
                default:
                    http_response_code(405);
                    echo json_encode(['message' => 'Method not found']);
                    break;
            }

            break;

        case 'FontGroup':

            $readFontGroupRepository = new ReadFontGroupRepository($conn);
            $writeFontGroupRepository = new WriteFontGroupRepository($conn);
            $fontGroupController = new FontGroup($readFontGroupRepository,$writeFontGroupRepository);

            switch($method){

                case 'index':
                    $response = $fontGroupController->index();
                    sendJsonResponse(200, $response); 
                    break;
        
                default:
                    http_response_code(405);
                    echo json_encode(['message' => 'Method not found']);
                    break;
            }

            break;

        default:

            http_response_code(405);
            echo json_encode(['message' => 'Controller not found']);
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