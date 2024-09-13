<?php

namespace App\Repositories\FontGroup;

use App\Interfaces\FontGroup\ReadFontGroupInterface;
use Exception;
use FontLib\Font as FontLibFont;

class ReadFontGroupRepository implements ReadFontGroupInterface
{

     private $conn;

     public function __construct($conn)
     {
          $this->conn = $conn;

          if ($this->conn->connect_error) {
               die("Connection failed: " . $this->conn->connect_error);
          }
     }


     public function allFontsGroup()
     {
          try {

               $query = $this->conn->prepare("SELECT 
               font_group.id as font_group_id, font_group.name as font_group_name, font_group.is_active, font_group.created_at, 
               font_group_data.name as font_name, font_group_data.specific_size, font_group_data.price_change  
               FROM font_group
               LEFT JOIN font_group_data ON font_group.id = font_group_data.font_group_id
               ORDER BY font_group.id DESC");

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
                    $fonts_group = $result->fetch_all(MYSQLI_ASSOC);

                    // Close the statement
                    $query->close();

                    $result = []; // This will hold the final result

                    // Assuming $queryResult contains the result from the SQL query
                    foreach ($fonts_group as $row) {
                         $fontGroupId = $row['font_group_id'];

                         // If the font group doesn't exist in the result array, create it
                         if (!isset($result[$fontGroupId])) {
                              $result[$fontGroupId] = [
                                   'id' => $fontGroupId,
                                   'font_group_name' => $row['font_group_name'],
                                   'is_active' => $row['is_active'],
                                   'created_at' => $row['created_at'],
                                   'font_group_data' => []
                              ];
                         }

                         // Add the font data under 'font_group_data' key
                         $result[$fontGroupId]['font_group_data'][] = [
                              'font_name' => $row['font_name'],
                              'specific_size' => $row['specific_size'],
                              'price_change' => $row['price_change']
                         ];
                    }

                    // Convert the result to an indexed array if needed
                    $finalResult = array_values($result);

                    return [
                         "status" => true,
                         "message" => "Fonts group retrieved successfully",
                         "data" => $finalResult
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
