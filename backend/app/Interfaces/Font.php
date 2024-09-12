<?php

namespace App\Interfaces;

interface Font{
    public function getFontName($params);
    public function uploadFonts($params);
    public function allFonts();
    public function deleteFonts($params);
}

?>