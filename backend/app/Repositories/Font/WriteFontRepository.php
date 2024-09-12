<?php

namespace App\Repositories\Font;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Interfaces\Font\WriteFont;
use Exception;

class WriteFontRepository implements WriteFont
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function uploadFonts($params)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO fonts (name, path, is_active, created_at) VALUES (?, ?, ?, ?)");

            if ($query === false) {
                return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
                ];
            }

            // Variables to bind
            $fontName = $params['fontName'];
            $fontPath = $params['destPath'];
            $isActive = 1; // Use 1 for true, 0 for false
            $createdAt = date("Y-m-d H:i:s");

            // Bind parameters
            $query->bind_param("ssis", $fontName, $fontPath, $isActive, $createdAt);

            // Execute the statement
            if (!$query->execute()) {
                return [
                    "status" => false,
                    "message" => $query->error,
                    "data" => []
                ];
            } else {

                // Close the statement
                $query->close();

                return [
                    "status" => true,
                    "message" => "$fontName Inserted",
                    "data" => []
                ];
            }
        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];
        }
    }

    public function deleteFonts($params){
        try {
            $id = $params['font_id'];


            //get font
            $query = $this->conn->prepare("SELECT * FROM fonts WHERE id = $id");

            if ($query === false) {
                return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
                ];
            }

            // Execute the statement
            if (!$query->execute()) {
                return [
                    "status" => false,
                    "message" => $query->error,
                    "data" => []
                ];
            } else {

                // Fetch results
                $result = $query->get_result();
                $fonts = $result->fetch_all(MYSQLI_ASSOC);

                // Close the statement
                $query->close();

                foreach($fonts as $font){
                    $path = realpath(__DIR__ . "/../../../" . $font['path']);

                    if(file_exists($path)){
                        unlink($path);
                    }

                }

            }

            $query = $this->conn->prepare("DELETE FROM fonts WHERE id = $id");

            if ($query === false) {
                return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
                ];
            }


            // Execute the statement
            if (!$query->execute()) {
                return [
                    "status" => false,
                    "message" => $query->error,
                    "data" => []
                ];
            } else {

                // Close the statement
                $query->close();

                return [
                    "status" => true,
                    "message" => "Font removed",
                    "data" => []
                ];
            }
        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];
        }
    }
}
