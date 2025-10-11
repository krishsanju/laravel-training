<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExampleOrder as Order;
use App\Enums\ExampleStatus as OrderStatus;

class ExampleOrderController extends Controller
{
    public function markAsProcessing(Order $order)
    {
        $order->update(['status' => OrderStatus::PROCESSING]);

        return redirect()->back()->with('success', 'Order is now being processed');
    }

}
