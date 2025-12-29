<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    public function index(Request $request)
    {
        $datas = Transaction::all();
        // dd($datas->toArray());
        return view('Admin.subscription.subscription-transactions.index', compact('datas'));
    }
}
