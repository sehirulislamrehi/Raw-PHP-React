<?php

namespace App\Repositories\Font;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Interfaces\Font\WriteFontInterface;
use Exception;

class WriteFontRepository implements WriteFontInterface
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

            // UPLOAD FONTS SQL STATEMENT
            $query = $this->conn->prepare("INSERT INTO fonts (name, path, is_active, created_at) VALUES (?, ?, ?, ?)");

            if ($query === false) {
                return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
                ];
            }

            $fontName = $params['fontName'];
            $fontPath = $params['destPath'];
            $isActive = 1;
            $createdAt = date("Y-m-d H:i:s");

            $query->bind_param("ssis", $fontName, $fontPath, $isActive, $createdAt);

            if (!$query->execute()) {
                return [
                    "status" => false,
                    "message" => $query->error,
                    "data" => []
                ];
            }
            // UPLOAD FONTS SQL STATEMENT


            // Close the statement
            $query->close();
            // Close the statement

            return [
                "status" => true,
                "message" => "$fontName Inserted",
                "data" => []
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];
        }
    }

    public function deleteFonts($params)
    {
        try {
            $id = $params['font_id'];


            //GET FONT SQL STATEMENT
            $query = $this->conn->prepare("SELECT * FROM fonts WHERE id = $id");

            if ($query === false) {
                return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
                ];
            }

            if (!$query->execute()) {
                return [
                    "status" => false,
                    "message" => $query->error,
                    "data" => []
                ];
            }

            $result = $query->get_result();
            $fonts = $result->fetch_all(MYSQLI_ASSOC);
            //GET FONT SQL STATEMENT

            //REMOVE THE FONTS FILE
            foreach ($fonts as $font) {
                $path = realpath(__DIR__ . "/../../../" . $font['path']);

                if (file_exists($path)) {
                    unlink($path);
                }
            }
            //REMOVE THE FONTS FILE

            //REMOVE THE FONTS
            $query = $this->conn->prepare("DELETE FROM fonts WHERE id = $id");
            if ($query === false) {
                return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
                ];
            }
            if (!$query->execute()) {
                return [
                    "status" => false,
                    "message" => $query->error,
                    "data" => []
                ];
            }
            $query->close();
            //REMOVE THE FONTS

            //REMOVE THE FONTS GROUP DATA
            $query = $this->conn->prepare("DELETE FROM font_group_data WHERE font_id = $id");
            if (!$query->execute()) {
                return [
                    "status" => false,
                    "message" => $query->error,
                    "data" => []
                ];
            }
            $query->close();
            //REMOVE THE FONTS GROUP DATA


            return [
                "status" => true,
                "message" => "Font removed",
                "data" => []
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];
        }
    }
}
