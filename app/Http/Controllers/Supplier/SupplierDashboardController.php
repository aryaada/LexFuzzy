<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;

class SupplierDashboardController extends Controller
{
    public function dashboard()
    {
        $totalOrder = Order::count();
        $pendingOrder = Order::where('status', 'submitted')->count();
        $processedOrder = Order::where('status', 'processed')->count();

        return view('supplier.dashboard', compact(
            'totalOrder',
            'pendingOrder',
            'processedOrder'
        ));
    }

    public function orders()
    {
        $orders = Order::with(['store', 'shipment'])
            ->leftJoin('shipments', 'shipments.order_id', '=', 'orders.id')
            ->select('orders.*')
            ->orderByRaw("
            CASE shipments.delivery_decision
                WHEN 'Cepat' THEN 1
                WHEN 'Normal' THEN 2
                WHEN 'Lambat' THEN 3
                ELSE 4
            END
        ")
            ->orderByDesc('shipments.fuzzy_score')
            ->orderBy('orders.created_at')
            ->get();

        return view('supplier.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['store', 'items.sparepart', 'shipment'])
            ->findOrFail($id);

        return view('supplier.order_detail', compact('order'));
    }
}
