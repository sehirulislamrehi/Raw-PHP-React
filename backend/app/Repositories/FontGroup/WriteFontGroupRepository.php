<?php

namespace App\Repositories\FontGroup;

use App\Interfaces\FontGroup\WriteFontGroupInterface;
use Exception;
use FontLib\Font as FontLibFont;

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

}
