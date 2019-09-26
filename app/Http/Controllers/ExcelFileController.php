<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ExcelFileConverterController;

class ExcelFileController extends Controller
{
    /**
     * @return array
     */
    public static function allowedExcelFileTypes()
    {
        $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        return $allowedFileType;
    }

    public static function getLocalStorageFullFilesPath()
    {
        return \dirname(__FILE__) . "/../../../storage/app/files/";;
    }

    /**
     * Return view with file content (or with out if not exist)
     * 
     * @return array
     */
    public function index()
    {
        $fileStoragePath = self::getLocalStorageFullFilesPath();

        $data = [];

        if(file_exists($fileStoragePath . "/excel/myExcelFile.xlsx")){
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileStoragePath . "/excel/myExcelFile.xlsx");

            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
        }
        
        return view('excel.index')
           ->with("collection", $data);
    }

    /**
     * Show form for uploading a new resource.
     */
    public function create()
    {
        return view('excel.create');
    }

    /**
     * On success redirect to main page
     */
    public function store(Request $request)
    {
        $uploadedFile = $request->file("file");
        if(!$uploadedFile){
            Session::flash('message', "File not found"); 
            return redirect()->back();
        }

        if(in_array($uploadedFile->getMimeType(), self::allowedExcelFileTypes()) !== true){
            Session::flash('message', "Wrong file type"); 
            return redirect()->back();
        }
        
        try {  
            // store to default laravel storage place
            $uploadedFile->storeAs("files/excel", "myExcelFile.xlsx");

            return redirect("/");

        } catch (\Throwable $th) {
            Session::flash('message', "File saving has been failed"); 
            return redirect()->back();
        }
    }


    /**
     * Show form for editing the specified resource.
     * If nothing found redirect back
     * 
     * @return array
     */
    public function edit(Request $request)
    {
        $params = $request->route()->parameters();

        $validatedData = Validator::make($params,[
            'key' => 'required|integer',
        ]);

        if ($validatedData->fails()) {
            Session::flash('message', $validatedData->messages()->first()); 
            return redirect()->back();
        }

        $fileStoragePath = self::getLocalStorageFullFilesPath();   
        
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileStoragePath . "/excel/myExcelFile.xlsx");
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $key = $request->key;
            $data = $this->getRowDataByLpKey($rows, $key);
            if($data == []){
                Session::flash('message', "Record not found"); 
                return redirect()->back();
            }

            return view('excel.edit')
                ->with("collection", $data);

        } catch (\Throwable $th) {
            Session::flash('message', "Sorry something went wrong"); 
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(),
        [
            'key' => 'required|integer',
            'figure_name' => 'required',
            'enthusiasm' => 'integer',
            'creativity' => 'integer',
            'brilliance' => 'integer',
        ]);

        if ($validatedData->fails()) {
            Session::flash('message', $validatedData->messages()->first()); 
            return redirect()->back();
        }
        
        $fileStoragePath = self::getLocalStorageFullFilesPath();    
        
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileStoragePath . "/excel/myExcelFile.xlsx");
            
            // Assumption that Lp. == A1 
            $CellLpKey = $request->key + 1; // (skip header row)

            $spreadsheet->getActiveSheet()->getCell("B".$CellLpKey)->setValue($request->figure_name);
            $spreadsheet->getActiveSheet()->getCell("C".$CellLpKey)->setValue($request->enthusiasm);
            $spreadsheet->getActiveSheet()->getCell("D".$CellLpKey)->setValue($request->creativity);
            $spreadsheet->getActiveSheet()->getCell("E".$CellLpKey)->setValue($request->brilliance);
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($fileStoragePath . "/excel/myExcelFile.xlsx");

            return redirect("/");

        } catch (\Throwable $th) {
            Session::flash('message', "Updating has been failed"); 
            return redirect()->back();
        }
    }

    /**
     * @param array $arrayData
     * @param int $rowKey
     * 
     * @return array
     */
    private function getRowDataByLpKey($arrayData, int $rowKey)
    {
        $searchedRow = [];
    
        foreach ($arrayData as $key => $row) {
            if($row[0] == $rowKey){
                $searchedRow = $row;
                break;
            }
        }

        return $searchedRow;
    }

    /**
     * Convert excel file to pdf 
     */
    public function convertToPDF()
    {
        $fileStoragePath = self::getLocalStorageFullFilesPath(); 

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileStoragePath . "/excel/myExcelFile.xlsx");
        $fileRows = $spreadsheet->getActiveSheet()->toArray();

        // pdf structure
        $htmlData = "<html><body><table>";
        foreach ($fileRows as $key => $row) {
            $htmlData .= "<tr>";
            foreach ($row as $key => $line) {
                $htmlData .= "<td>$line</td>";
            }
            $htmlData .= "/<tr>";
        }
        $htmlData .= "</table></body></html>";
        
        if(ExcelFileConverterController::convertToPDFAndSave($htmlData, "", ($fileStoragePath . "pdf/"), "myPdfFile.pdf"))
            Session::flash('message', "File has been converted successfully"); 
        else
            Session::flash('message', "File conversion has been failed"); 

        return redirect("/");
    }
}
