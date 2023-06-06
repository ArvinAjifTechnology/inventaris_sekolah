<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\BorrowExport;
use Illuminate\Support\Facades\DB;

class BorrowReportController extends Controller
{
    public function index()
    {
        $borrows = Borrow::query();
        $sum_of_sub_total = 0;
        return view('borrow-report.index', compact('borrows'));
    }

    public function generateReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        $query = "SELECT borrows.*, CONCAT(users.first_name, ' ', users.last_name) AS user_full_name, users.*, items.*
        FROM borrows
        INNER JOIN users ON borrows.user_id = users.id
        INNER JOIN items ON borrows.item_id = items.id";

        // Filter tanggal
        if ($startDate && $endDate) {
            $query .= " WHERE borrows.borrow_date BETWEEN '$startDate' AND '$endDate'";
        }

        // Pencarian
        if ($search) {
            $query .= " AND (borrows.borrow_code LIKE '%$search%'
                      OR borrows.borrow_status LIKE '%$search%'
                      OR items.item_name LIKE '%$search%'
                      OR items.item_code LIKE '%$search%'
                      OR users.name LIKE '%$search%'
                      OR users.email LIKE '%$search%')";
        }

        $borrows = DB::select($query);

        return view('borrow-report.index', compact('borrows', 'startDate', 'endDate', 'search'));
    }



    public function export(Request $request)
    {
        // dd($request->all());
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        $type = $request->input('type');

        $query = Borrow::query();
        // dd($query);
        // Filter tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('borrow_date', [$startDate, $endDate]);
        }

        // Pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('borrow_code', 'LIKE', "%$search%")
                    ->orWhere('borrow_status', 'LIKE', "%$search%")
                    ->orWhereHas('item', function ($q) use ($search) {
                        $q->where('item_name', 'LIKE', "%$search%")
                            ->orWhere('item_code', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
            });
            // dd($query);

            $borrows = $query->get();

            if ($type === 'pdf') {
                $pdf = PDF::loadView('borrow-report.export-pdf', compact('borrows', 'startDate', 'endDate', 'search'));
                return $pdf->download('borrow-report.pdf');
            } elseif ($type === 'excel') {
                return Excel::download(new BorrowExport($borrows, $startDate, $endDate, $search), 'borrow-report.xlsx');
            }
        }
    }
}
