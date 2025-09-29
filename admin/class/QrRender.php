<?php
require_once __DIR__.'/vendor/autoload.php';

use BaconQrCode\Common\ErrorCorrectionLevel;
//use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Greenter\Model\Sale\BaseSale;

/**
 * Class QrRender.
 */
class QrRender
{
    /**
     * @param BaseSale $sale
     *
     * @return string
     */
    public function getImage($sale)
    {
        $client = $sale->getClient();
        $params = [
            $sale->getCompany()->getRuc(),
            $sale->getTipoDoc(),
            $sale->getSerie(),
            $sale->getCorrelativo(),
            number_format($sale->getMtoIGV(), 2, '.', ''),
            number_format($sale->getMtoImpVenta(), 2, '.', ''),
            $sale->getFechaEmision()->format('Y-m-d'),
            $client->getTipoDoc(),
            $client->getNumDoc(),
        ];
        $content = implode('|', $params).'|';

        return $this->getQrImage($content);
    }

    private function getQrImage(string $content)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(120, 0),
            //new SvgImageBackEnd()
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        return $writer->writeFile($content, __DIR__.'/../../assets/images/code_qr.png');
    }
}