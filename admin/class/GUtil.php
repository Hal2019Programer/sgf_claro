<?php
use Greenter\See;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\CdrResponse;

final class GUtil
{
    private static $current;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$current instanceof self) {
            self::$current = new self();
        }

        return self::$current;
    }

    /**
     * @param string $endpoint
     * @return See
     */
    public function getSee($endpoint)
    {
        /*$see = new See();
        $see->setService($endpoint);
				//$see->setCodeProvider(new XmlErrorCodeProvider());
        $see->setCertificate(file_get_contents(__DIR__ . '/../resource/certificate.cer'));
        $see->setCredentials('20549511750JROMERO1', 'l4m3rc3d2018');
        $see->setCachePath(__DIR__ . '/../cache');

        return $see;*/
				
			$see = new See();
      $see->setService($endpoint);
			$see->setCertificate(file_get_contents(__DIR__ . '/../resource/certificate.cer'));
	  $see->setCredentials('10413437186USUARIO2', 'Heli2025'); //10413437186USUARIO2 - Heli2025
      $see->setCachePath(__DIR__ . '/../cache');
      return $see;
    }

    public function getResponseFromCdr(CdrResponse $cdr)
    {
        $result = <<<HTML
        <h2>Respuesta SUNAT:</h2><br>
        <b>ID:</b> {$cdr->getId()}<br>
        <b>CODE:</b>{$cdr->getCode()}<br>
        <b>DESCRIPTION:</b>{$cdr->getDescription()}<br>
HTML;

        return $result;
    }

    public function writeXml(DocumentInterface $document, $xml)
    {
        $this->writeFile($document->getName().'.xml', $xml);
    }

    public function writeCdr(DocumentInterface $document, $zip)
    {
        $this->writeFile('R-'.$document->getName().'.zip', $zip);
    }

    public function writeFile($filenam, $content)
    {
        if (getenv('GREENTER_NO_FILES')) {
            return;
        }
        file_put_contents(__DIR__ . '/../../datasunat/'.$filenam, $content);
    }

    public function getPdf(DocumentInterface $document)
    {
        $html = new HtmlReport('', [
            'cache' => __DIR__ . '/../cache',
            'strict_variables' => true,
        ]);
        $template = $this->getTemplate($document);
        if ($template) {
            $html->setTemplate($template);
        }

        $render = new PdfReport($html);
        $render->setOptions( [
            'no-outline',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            'footer-html' => __DIR__.'/../resources/footer.html',
        ]);
        $binPath = self::getPathBin();
        if (file_exists($binPath)) {
            $render->setBinPath($binPath);
        }
        $hash = $this->getHash($document);
        $params = self::getParametersPdf();
        $params['system']['hash'] = $hash;
        $params['user']['footer'] = '<div style="
        padding: 1px;
        font-size: 0.9em;
        margin-top: -40px;
        margin-bottom: 5px;">
        <strong style="font-size:11px;">Condiciones generales para nuestros clientes:</strong><br><br>
        <ul style="font-size:9px;">
        <li>Transcurrido 15 días desde que se haya efectuado el despacho correspondiente y/o la finalización del servicio, no se aceptará devoluciones ni reclamos.</li>
        <li>En caso no recoja su mercadería dentro de los 20 días posteriores de haberles efectuado el servicio, acepta expresamente que nuestra empresa proceda a realizar el cobro de almacenamiento Por un Valor USD 50 Diarios +IGV. </li>
        <li>Pasado los 120 días de tela no recogida, la misma se considerara como abandonada y nuestra empresa procederá conforme a las Leyes Peruanas vigentes.</li>
      </ul> 
        consulte en <a href="http://www.texlamerced.com/">texlamerced.com</a>
        </div>';

        $pdf = $render->render($document, $params);

        if ($pdf === false) {
            $error = $render->getExporter()->getError();
            echo 'Error: '.$error;
            exit();
        }

        // Write html
        $this->writeFile($document->getName().'.html', $render->getHtml());

        return $pdf;
    }

    public static function generator($item, $count)
    {
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $items[] = $item;
        }

        return $items;
    }

    public function showPdf($content, $filename)
    {
        $this->writeFile($filename, $content);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($content));

        echo $content;
    }

    public static function getPathBin()
    {
        $path = __DIR__.'/../vendor/bin/wkhtmltopdf';
        if (self::isWindows()) {
            $path .= '.exe';
        }

        return $path;
    }

    public static function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    public static function inPath($command) {
        $whereIsCommand = self::isWindows() ? 'where' : 'which';

        $process = proc_open(
            "$whereIsCommand $command",
            array(
                0 => array("pipe", "r"), //STDIN
                1 => array("pipe", "w"), //STDOUT
                2 => array("pipe", "w"), //STDERR
            ),
            $pipes
        );
        if ($process !== false) {
            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            return $stdout != '';
        }

        return false;
    }

    private function getTemplate($document)
    {
        $className = get_class($document);

        switch ($className) {
            case \Greenter\Model\Retention\Retention::class:
                $name = 'retention';
                break;
            case \Greenter\Model\Perception\Perception::class:
                $name = 'perception';
                break;
            case \Greenter\Model\Despatch\Despatch::class:
                $name = 'despatch';
                break;
            case \Greenter\Model\Summary\Summary::class:
                $name = 'summary';
                break;
            case \Greenter\Model\Voided\Voided::class:
            case \Greenter\Model\Voided\Reversion::class:
                $name = 'voided';
                break;
            default:
                return '';
        }

        return $name.'.html.twig';
    }

    private function getHash(DocumentInterface $document)
    {
        $see = $this->getSee('');
        $xml = $see->getXmlSigned($document);

        $hash = (new \Greenter\Report\XmlUtils())->getHashSign($xml);

        return $hash;
    }

    private static function getParametersPdf()
    {
        $logo = file_get_contents(__DIR__.'/../img/sector-logo.jpeg');

        return [
            'system' => [
                'logo' => $logo,
                'hash' => ''
            ],
            'user' => [
                'resolucion' => '155-2017',
                'header' => 'Telf: <b>3487257 - 983487749',
            ]
        ];
    }
}