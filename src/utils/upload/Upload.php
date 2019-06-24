<?php
namespace Utils\Upload;

use Slim\Http\UploadedFile;

class Upload {
    /**
    * Move o arquivo para um diretório
    *
    * @param mixed $directory
    * @param UploadedFile $uploadedFile
    * @return String
    * @todo Mover para um objeto específico
    */
    public function moveUploadedFile($directory, UploadedFile $uploadedFile): String
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        
        return $filename;
    }
}
