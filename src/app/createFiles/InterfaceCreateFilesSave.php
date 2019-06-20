<?php
namespace App\CreateFiles;

interface InterfaceCreateFilesSave
{
    public function save(String $toConvert, String $lang, String $directory): String;
}