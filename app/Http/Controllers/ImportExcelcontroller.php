<?php

namespace App\Http\Controllers;

use App\Imports\StaffImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelcontroller extends Controller
{
    public function ImportUserData(Request $request)
    {

        $request->validate([

            'xlupload' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('xlupload');

        $extensions = array("xlsx", "xls");

        $result = array($file->getClientOriginalExtension());

        Excel::import(new StaffImport, $file);

        return redirect()->back()->with('message', 'Data Imported Successfully');
    }
}
