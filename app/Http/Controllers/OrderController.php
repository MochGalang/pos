<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\order_detail;
use App\Models\Member;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['categories'] = Category::with('product')->get();
        $data['members'] = Member::all();
        return view('order.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Pastikan validasi dilakukan
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'order_payload' => 'required|string',
        ]);

        $payload = json_decode($validated['order_payload'], true);

        if (!$payload || empty($payload['items'])) {
            // Mengubah redirect error menjadi JSON response
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada item dalam pesanan.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = new Order();
            $order->invoice = 'INV' . time();
            $order->total = $payload['total'] ?? array_sum(array_column($payload['items'], 'price'));

            $order->member_id = $validated['member_id'];
            $order->save();

            // Create order details
            foreach ($payload['items'] as $item) {
                $detail = new order_detail();
                $detail->order_id = $order->id;
                $detail->product_id = $item['id'];
                $detail->quantity = $item['qty'];
                $detail->price = $item['price']; // harga per item
                $detail->save();
            }

            DB::commit();

            // *** PERUBAHAN KRITIS DI SINI: Mengembalikan response JSON dengan print_url ***
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil disimpan.',
                // Menggunakan route() untuk mendapatkan URL print
                'print_url' => route('order.print', $order->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            // Mengubah redirect error menjadi JSON response
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * Show printable invoice for the order and trigger print.
     */
    public function print(Order $order)
    {
        // Load order details dan produk terkait
        $details = order_detail::where('order_id', $order->id)->get();
        $productIds = $details->pluck('product_id')->unique()->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return view('print', [
            'order' => $order,
            'details' => $details,
            'products' => $products,
        ]);
    }
}
