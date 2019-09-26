<?php

namespace App\Http\Controllers;

class ExcelFileConverterController extends Controller
{
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
    public static function convertToPDFAndSave($HTML_BODY, $STYLES_SHEET, $placeToSave, $saveAs): bool
    {
        try {
            $mpdf = new \Mpdf\Mpdf();
                
            $mpdf->WriteHTML($STYLES_SHEET,\Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($HTML_BODY,\Mpdf\HTMLParserMode::HTML_BODY);

            $mpdf->Output($placeToSave . $saveAs, "F");
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
