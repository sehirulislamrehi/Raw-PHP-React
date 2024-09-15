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

               //FETCH GROUP GROUP WITH DETAILS SQL STATEMENT
               $query = $this->conn->prepare("SELECT 
               font_group.id as font_group_id, font_group.name as font_group_name, font_group.is_active, font_group.created_at, 
               font_group_data.name as font_name, font_group_data.specific_size, font_group_data.price_change, font_group_data.font_id,
               fonts.name as fonts_table_font_name  
               FROM font_group
               LEFT JOIN font_group_data ON font_group.id = font_group_data.font_group_id
               LEFT JOIN fonts ON font_group_data.font_id = fonts.id
               ORDER BY font_group.id DESC");
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
               $fonts_group = $result->fetch_all(MYSQLI_ASSOC);
               $query->close();
               //FETCH GROUP GROUP WITH DETAILS SQL STATEMENT

               $result = []; 

               foreach ($fonts_group as $row) {
                    $fontGroupId = $row['font_group_id'];

                    if (!isset($result[$fontGroupId])) {
                         $result[$fontGroupId] = [
                              'id' => $fontGroupId,
                              'font_group_name' => $row['font_group_name'],
                              'is_active' => $row['is_active'],
                              'created_at' => $row['created_at'],
                              'font_group_data' => []
                         ];
                    }

                    if($row['fonts_table_font_name']){
                         $result[$fontGroupId]['font_group_data'][] = [
                              'fonts_table_font_name' => $row['fonts_table_font_name'],
                              'font_name' => $row['font_name'],
                              'specific_size' => $row['specific_size'],
                              'price_change' => $row['price_change']
                         ];
                    }
                    
               }

               $finalResult = array_values($result);

               return [
                    "status" => true,
                    "message" => "Fonts group retrieved successfully",
                    "data" => $finalResult
               ];
          } catch (Exception $e) {
               return [
                    "status" => false,
                    "message" => $e->getMessage(),
                    "data" => []
               ];
          }
     }

     public function getFontsGroupById($params)
     {
          try {

               $id = $params["font_group_id"];

               //FETCH GROUP GROUP WITH DETAILS SQL STATEMENT
               $query = $this->conn->prepare("SELECT 
               font_group.id as font_group_id, font_group.name as font_group_name, font_group.is_active, font_group.created_at,
               font_group_data.name as font_name, font_group_data.specific_size, font_group_data.price_change, font_group_data.font_id, font_group_data.font_id,
               fonts.name as fonts_table_font_name  
               FROM font_group
               LEFT JOIN font_group_data ON font_group.id = font_group_data.font_group_id
               LEFT JOIN fonts ON font_group_data.font_id = fonts.id
               WHERE font_group.id = '$id'");
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
               $fonts_group = $result->fetch_all(MYSQLI_ASSOC);
               $query->close();
               //FETCH GROUP GROUP WITH DETAILS SQL STATEMENT

               $result = []; 

               foreach ($fonts_group as $row) {
                    $fontGroupId = $row['font_group_id'];

                    if (!isset($result['id'])) {
                         $result = [
                              'id' => $fontGroupId,
                              'font_group_name' => $row['font_group_name'],
                              'is_active' => $row['is_active'],
                              'created_at' => $row['created_at'],
                              'font_group_data' => []
                         ];
                    }

                    $result['font_group_data'][] = [
                         'fonts_table_font_name' => $row['fonts_table_font_name'],
                         'font_name' => $row['font_name'],
                         'specific_size' => $row['specific_size'],
                         'price_change' => $row['price_change'],
                         'font_id' => $row['font_id'],
                    ];
               }

               if(empty($result)){
                    return [
                         "status" => false,
                         "message" => "No data found",
                         "data" => $result
                    ];
               }

               return [
                    "status" => true,
                    "message" => "Fonts group retrieved successfully",
                    "data" => $result
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
