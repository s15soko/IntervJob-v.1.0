<?php

namespace App\Http\Controllers;

class ExcelFileConverterController extends Controller
{
    public static function convertToPDF($HTML_BODY, $STYLES_SHEET)
    {
        $mpdf = new \Mpdf\Mpdf();
                
        $mpdf->WriteHTML($STYLES_SHEET,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($HTML_BODY,\Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf;
    }

    /**
     * Convert data to pdf file
     * 
     * @param array $HTML_BODY
     * @param string $STYLES_SHEET
     * @param string $placeToSave
     * @param string $saveAs
     * 
     * @return bool
     * || if true file has been saved on system disk
     */
    public static function convertToPDFAndSave($HTML_BODY, $STYLES_SHEET, $placeToSave, $saveAs)
    {
        try {
            $mpdf = ExcelFileConverterController::convertToPDF($HTML_BODY, $STYLES_SHEET);
            $mpdf->Output($placeToSave . $saveAs, "F");

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Convert data to pdf file and download
     * 
     * @param array $HTML_BODY
     * @param string $STYLES_SHEET
     * @param string $saveAs
     * 
     * @return bool
     * || if true file has been downloaded 
     */
    public static function convertToPDFAndDownload($HTML_BODY, $STYLES_SHEET, $saveAs)
    {
        try {
            $mpdf = ExcelFileConverterController::convertToPDF($HTML_BODY, $STYLES_SHEET);
            $mpdf->Output($saveAs, "D");

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
