<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pricing
     */
    public function create()
    {
        return view('order.pricing', [
            'title' => 'Pricing'
        ]);
    }

    /**
     * Membuat pesanan baru dan membuat token Midtrans
     */
    public function store(Request $request)
    {
        try {
            $duration = $request->input('duration');

            DB::beginTransaction();

            // Create Order
            $payment = Payment::create([
                'quantity' => $duration,
                'total' => $duration * 50000,
                'status' => 'unpaid',
                'user_id' => auth()->user()->id
            ]);

            $snapToken = Payment::getMidtransSnapToken($payment);
            $title = "Checkout";

            DB::commit();

            return view('order.checkout', compact('title', 'snapToken', 'payment'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with("error", "Order failed");
        }
    }

    /**
     * Memperbaharui status pembayaran dan masa berlangganan
     */
    public function update(Request $request, Payment $payment)
    {
        try {
            $server_key = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);
            if ($hashed == $request->signature_key) {
                if ($request->transaction_status == 'capture') {
                    $payment = Payment::find($request->order_id);
                    $payment->update([
                        'payment_date' => $request->transaction_time,
                        'method' => $request->payment_type,
                        'status' => 'paid'
                    ]);

                    $payment->user->update([
                        'role' => 'pelukis'
                    ]);

                    $payment->user->subscription->update([
                        'expired_date' => Carbon::now()->addMonths($payment->quantity)->format('Y-m-d H:i:s')
                    ]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "failed");
        }
    }
}
