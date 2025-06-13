<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BodExport;

class ExportReportController extends Controller
{
    public function export(Request $request)
    {
        $tgl = now()->format('Y-m-d');
        return Excel::download(
            new BodExport, 
            'export-data-' . $tgl . '.xlsx'
        );
    }
}
