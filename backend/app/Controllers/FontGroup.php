<?php

namespace App\Controllers;

use App\Interfaces\FontGroup as InterfacesFontGroup;
use Exception;


class FontGroup
{

     private InterfacesFontGroup $fontGroupRepository;

     public function __construct(InterfacesFontGroup $fontGroupRepository)
     {
          $this->fontGroupRepository = $fontGroupRepository;
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

            return $response = $this->fontGroupRepository->allFontsGroup();
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

          if ($_SERVER['REQUEST_METHOD'] != "POST") {
               return [
                    "status" => false,
                    "message" => "POST method is supported for the route. GET found.",
                    "data" => []
               ];
          }

          try{

          }
          catch( Exception $e ){
               return [
                    "status" => false,
                    "message" => $e->getMessage(),
                    "data" => []
               ];
          }
     }
}
