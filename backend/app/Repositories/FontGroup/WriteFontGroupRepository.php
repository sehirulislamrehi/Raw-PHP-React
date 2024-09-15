<?php

namespace App\Repositories\FontGroup;

use App\Interfaces\FontGroup\WriteFontGroupInterface;
use Exception;

class WriteFontGroupRepository implements WriteFontGroupInterface
{

     private $conn;

     public function __construct($conn)
     {
          $this->conn = $conn;

          if ($this->conn->connect_error) {
               die("Connection failed: " . $this->conn->connect_error);
          }
     }

     public function createFontsGroup($params)
     {
          $fontGroupName = $params['groupName'];
          $now = date("Y-m-d H:i:s");
          $insertFontGroupSQL = "INSERT INTO font_group(name,is_active,created_at) VALUES('" . $fontGroupName . "','1','" . $now . "')";

          $this->conn->begin_transaction();

          if ($this->conn->query($insertFontGroupSQL) === TRUE) {
               $lastInsertId = $this->conn->insert_id;
               $rowData = json_decode($params['rowData']);

               $insertFontGroupDataSql = "INSERT INTO font_group_data (font_group_id, name, font_id, specific_size, price_change) VALUES ";
               $values = [];
               foreach ($rowData as $data) {
                    $lastInsertIdEscaped = $this->conn->real_escape_string($lastInsertId);
                    $nameEscaped = $this->conn->real_escape_string($data->fontName);
                    $fontIdEscaped = $this->conn->real_escape_string($data->fontType);
                    $specificSizeEscaped = $this->conn->real_escape_string($data->specificSize);
                    $priceChangeEscaped = $this->conn->real_escape_string($data->priceChange);

                    $values[] = "('$lastInsertIdEscaped', '$nameEscaped', '$fontIdEscaped', '$specificSizeEscaped', '$priceChangeEscaped')";
               }

               $insertFontGroupDataSql .= implode(", ", $values);

               if ($this->conn->query($insertFontGroupDataSql) === TRUE) {
                    $this->conn->commit();
                    return [
                         "status" => true,
                         "message" => "Font group created",
                         "data" => []
                    ];
               } else {
                    $this->conn->rollback();
                    return [
                         "status" => false,
                         "message" => $this->conn->error,
                         "data" => []
                    ];
               }
          } else {
               $this->conn->rollback();
               return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
               ];
          }
     }


     public function deleteFontsGroup($params)
     {
          try {
               $id = $params['font_group_id'];

               //TRANSACTION START
               $this->conn->begin_transaction();

               //DELETE FONT GROUP SQL               
               $query = $this->conn->prepare("DELETE FROM font_group WHERE id = $id");

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
               //DELETE FONT GROUP SQL
               
               //DELETE FONT GROUP DATA SQL               
               $query = $this->conn->prepare("DELETE FROM font_group_data WHERE font_group_id = $id");

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
               //DELETE FONT GROUP DATA SQL


               $this->conn->commit();
               return [
                    "status" => true,
                    "message" => "Font group removed",
                    "data" => []
               ];




          } catch (Exception $e) {
               $this->conn->rollback();
               return [
                    "status" => false,
                    "message" => $e->getMessage(),
                    "data" => []
               ];
          }
     }

     public function updateFontsGroup($params)
     {
          $fontGroupName = $params['groupName'];
          $id = $params['id'];
          $updateFontGroupSQL = "UPDATE font_group SET name = '" . $fontGroupName . "' WHERE id = '$id'";

          $this->conn->begin_transaction();

          if ($this->conn->query($updateFontGroupSQL) === TRUE) {

               //DELETE FONT GROUP DATA SQL               
               $query = $this->conn->prepare("DELETE FROM font_group_data WHERE font_group_id = $id");
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
               //DELETE FONT GROUP DATA SQL

               $rowData = json_decode($params['rowData']);

               $insertFontGroupDataSql = "INSERT INTO font_group_data (font_group_id, name, font_id, specific_size, price_change) VALUES ";
               $values = [];
               foreach ($rowData as $data) {
                    $lastInsertIdEscaped = $this->conn->real_escape_string($id);
                    $nameEscaped = $this->conn->real_escape_string($data->fontName);
                    $fontIdEscaped = $this->conn->real_escape_string($data->fontType);
                    $specificSizeEscaped = $this->conn->real_escape_string($data->specificSize);
                    $priceChangeEscaped = $this->conn->real_escape_string($data->priceChange);

                    $values[] = "('$id', '$nameEscaped', '$fontIdEscaped', '$specificSizeEscaped', '$priceChangeEscaped')";
               }

               $insertFontGroupDataSql .= implode(", ", $values);

               if ($this->conn->query($insertFontGroupDataSql) === TRUE) {
                    $this->conn->commit();
                    return [
                         "status" => true,
                         "message" => "Font group updated",
                         "data" => []
                    ];
               } else {
                    $this->conn->rollback();
                    return [
                         "status" => false,
                         "message" => $this->conn->error,
                         "data" => []
                    ];
               }
          } else {
               $this->conn->rollback();
               return [
                    "status" => false,
                    "message" => $this->conn->error,
                    "data" => []
               ];
          }
     }
}
