<?php

namespace App\Controllers;

use App\Interfaces\Font\ReadFont;
use App\Interfaces\Font\WriteFont;
use Exception;


class Font
{

    private ReadFont $readFontRepository;
    private WriteFont $writeFontRepository;

    public function __construct(ReadFont $readFontInterface, WriteFont $writeFontInterface)
    {
        $this->readFontRepository = $readFontInterface;
        $this->writeFontRepository = $writeFontInterface;
    }


    public function index()
    {
        try{

            if( $_SERVER['REQUEST_METHOD'] != "GET" ){
                return [
                    "status" => false,
                    "message" => "GET method is supported for the route. POST found.",
                    "data" => []
                ];
            }

            return $response = $this->readFontRepository->allFonts();
        }
        catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];
        }
    }

    public function create()
    {

        if( $_SERVER['REQUEST_METHOD'] != "POST" ){
            return [
                "status" => false,
                "message" => "POST method is supported for the route. GET found.",
                "data" => []
            ];
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
        
            // Get the file extension using pathinfo
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            if($fileExtension != "ttf"){
                return [
                    "status" => false,
                    "message" => "File type must be .ttf",
                    "data" => []
                ];
            }

            // Define where to move the uploaded file
            $uploadDir = __DIR__ . '/../../public/uploads/';
            $destPath = $uploadDir . $fileName;

            // Ensure upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }


            // Move the file to the designated directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Extract font name
                try {

                    $fontName = $this->readFontRepository->getFontName($destPath);

                    //insert the font
                    return $response = $this->writeFontRepository->uploadFonts([
                        'destPath' => "public/uploads/$fileName",
                        'fileName' => $fileName,
                        'fontName' => $fontName,
                    ]);

                } catch (Exception $e) {
                    return [
                        "status" => false,
                        "message" => $e->getMessage(),
                        "data" => []
                    ];
                }
            } else {
                return [
                    "status" => false,
                    "message" => "Failed to move uploaded file",
                    "data" => []
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => "No file uploaded or upload error",
                "data" => []
            ];
        }
    }

    public function delete(){
        try{

            if( $_SERVER['REQUEST_METHOD'] != "POST" ){
                return [
                    "status" => false,
                    "message" => "POST method is supported for the route. GET found.",
                    "data" => []
                ];
            }

            return $response = $this->writeFontRepository->deleteFonts($_REQUEST);
        }
        catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];
        }
    }
}
