<?php
namespace App\Controller;

use \SlimUtils\Controller\BaseController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile;
use App\CreateFiles\ToTxt;

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
     * @todo Validar linguas disponíveis
     */
    public function convert(Request $request, Response $response, Array $args)
    {
        //Get Body
        $body = $request->getParsedBody();

        //Upload image
        $directory = $this->toConvertDir;
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['image'];
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return $response->write('Não deu certo o upload');
        }
        $filename = $this->moveUploadedFile($directory, $uploadedFile);
        $this->logger->debug('Upload realizado com sucesso', ['file' => $filename]);

        //Convert to OCR
        $imagePath = $directory. DIRECTORY_SEPARATOR . $filename; 
        $textOCR = $this->tesseract
            ->image($imagePath)
            ->lang($body['lang'])
            ->run();
        $this->logger->debug('Converted to string: ' . $imagePath);

        //Convert to Txt
        $toTxt = new ToTXT($this->tesseract);
        $localTxt = $toTxt->save($imagePath, $body['lang'], $this->toTxtDir);
        $this->logger->debug('Converted to TXT, it is ' . $localTxt);
        
        //Response
        $resArr['success'] = true;
        $resArr['text'] = $textOCR;
        $resArr['pathToTxt'] = $localTxt;
        return $response->withJson($resArr);
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