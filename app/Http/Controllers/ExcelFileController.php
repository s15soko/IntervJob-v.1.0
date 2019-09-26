<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

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
     */
    public function edit(Request $request)
    {
        
    }

    public function update()
    {
        
    }
}