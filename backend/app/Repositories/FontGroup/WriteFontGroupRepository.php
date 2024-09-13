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
               $fontGroupDataArr = [];

               $insertFontGroupDataSql = "INSERT INTO font_group_data (font_group_id, name, font_id, specific_size, price_change) VALUES ";
               $values = []; 
               foreach ($rowData as $data) {
                    $lastInsertIdEscaped = $this->conn->real_escape_string($lastInsertId);
                    $nameEscaped = $this->conn->real_escape_string($data->fontName);
                    $fontIdEscaped = $this->conn->real_escape_string($data->fontType);
                    $specificSizeEscaped = $this->conn->real_escape_string($data->specificSize);
                    $priceChangeEscaped = $this->conn->real_escape_string($data->priceChange);

                    // Append each set of values to the array
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
               }
               else{
                    $this->conn->rollback();
                    return [
                         "status" => false,
                         "message" => $this->conn->error,
                         "data" => []
                    ];
               }


               // $this->conn->commit();
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
