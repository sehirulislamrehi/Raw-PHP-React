<?php

namespace App\Repositories\Font;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Interfaces\Font\ReadFontInterface;
use Exception;
use FontLib\Font as FontLibFont;

class ReadFontRepository implements ReadFontInterface
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getFontName($filePath)
    {
        $font = FontLibFont::load($filePath);
        $font->parse(); // Parse the font file
        return $font->getFontName();
    }

    public function allFonts()
    {
        try {

            //GET ALL FONTS SQL STATEMENT
            $query = $this->conn->prepare("SELECT * FROM fonts ORDER BY id DESC");
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
            //GET ALL FONTS SQL STATEMENT

            // Close the statement
            $query->close();
            // Close the statement

            return [
                "status" => true,
                "message" => "Fonts retrieved successfully",
                "data" => $fonts
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
