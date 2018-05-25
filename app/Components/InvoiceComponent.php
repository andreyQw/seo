<?php

namespace App\Components;

use PDF;
use App\Model\Order;
use App\Invoice;

class InvoiceComponent
{

    protected static function set(Order $order)
    {

        $path = storage_path() . '/app/public/invoices/' . time() . "_invoice.pdf";

        $invoice = new Invoice([
            'path' => $path
        ]);
        $invoice->order()->associate($order);
        $invoice->save();
        
        PDF::loadView('invoice.invoice', [
            'invoice' => $invoice,
        ])->setPaper('a4')->save($path);

    }

}