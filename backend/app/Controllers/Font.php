<?php

namespace App\Controllers;

use App\Interfaces\Font as InterfacesFont;
use Exception;


class Font
{

    private InterfacesFont $font_repository;

    public function __construct(InterfacesFont $font_interface)
    {
        $this->font_repository = $font_interface;
    }


    // Handle GET requests (get fonts data)
    public function index()
    {
        try{
            return $response = $this->font_repository->allFonts();
        }
        catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];
        }
    }

    // Handle POST requests (Create a new font)
    public function create()
    {

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];

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

                    $fontName = $this->font_repository->getFontName($destPath);

                    //insert the font
                    return $response = $this->font_repository->uploadFonts([
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
            return $response = $this->font_repository->deleteFonts($_REQUEST);
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
