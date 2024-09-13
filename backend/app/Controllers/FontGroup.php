<?php

namespace App\Controllers;

use App\Interfaces\FontGroup\ReadFontGroupInterface;
use App\Interfaces\FontGroup\WriteFontGroupInterface;
use Exception;


class FontGroup
{

     private ReadFontGroupInterface $readFontGroupRepository;
     private WriteFontGroupInterface $writeFontGroupRepository;

     public function __construct(ReadFontGroupInterface $readFontGroupInterface, WriteFontGroupInterface $writeFontGroupInterface)
     {
          $this->readFontGroupRepository = $readFontGroupInterface;
          $this->writeFontGroupRepository = $writeFontGroupInterface;
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

            return $response = $this->readFontGroupRepository->allFontsGroup();
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
        try{

            if( $_SERVER['REQUEST_METHOD'] != "POST" ){
                return [
                    "status" => false,
                    "message" => "POST method is supported for the route. GET found.",
                    "data" => []
                ];
            }

            return $response = $this->writeFontGroupRepository->createFontsGroup($_REQUEST);
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
