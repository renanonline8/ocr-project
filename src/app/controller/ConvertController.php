<?php
namespace App\Controller;

use \SlimUtils\Controller\BaseController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile;

final class ConvertController extends BaseController
{
    /**
     * Convert image using OCR
     *
     * @param Request $request
     * @param Response $response
     * @param Array $args
     * @return void
     * @todo Marcar tempo da conversão e tamanho do arquivo
     */
    public function convert(Request $request, Response $response, Array $args)
    {
        //Upload image
        $directory = $this->toConvertDir;
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['image'];
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return $response->write('Não deu certo o upload');
        }
        $filename = $this->moveUploadedFile($directory, $uploadedFile);
        $this->logger->debug('Upload realizado com sucesso', ['file' => $filename]);
        
        return $response->write('Convertido');
    }

    /**
     * Move o arquivo para um diretório
     *
     * @param mixed $directory
     * @param UploadedFile $uploadedFile
     * @return String
     * @todo Mover para um objeto específico
     */
    private function moveUploadedFile($directory, UploadedFile $uploadedFile): String
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

}