<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    protected $transactions;
    protected $total;
    protected $startDate;
    protected $endDate;

    public function __construct($transactions, $total, $startDate, $endDate)
    {
        $this->transactions = $transactions;
        $this->total = $total;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('exports.transaksi', [
            'transactions' => $this->transactions,
            'total' => $this->total,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
