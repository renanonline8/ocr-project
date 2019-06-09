<?php
namespace Utils\File;

class FileName
{
    public function generateName(): String
    {
        $basename = bin2hex(random_bytes(8));
        return $basename;
    }
}