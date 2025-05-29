<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopupController extends Controller
{
    public function index()
    {
        // Data untuk metode pembayaran
        $paymentMethods = [
            [
                'id' => 'bca',
                'name' => 'Bank Central Asia',
                'code' => 'BCA',
                'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/5/5c/Bank_Central_Asia.svg/200px-Bank_Central_Asia.svg.png'
            ],
            [
                'id' => 'mandiri',
                'name' => 'Mandiri',
                'code' => 'MANDIRI',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/200px-Bank_Mandiri_logo_2016.svg.png'
            ],
            [
                'id' => 'bri',
                'name' => 'BRI',
                'code' => 'BRI',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/200px-BANK_BRI_logo.svg.png'
            ],
            [
                'id' => 'qris',
                'name' => 'QRIS',
                'code' => 'QRIS',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/de/QRIS_logo.svg/200px-QRIS_logo.svg.png'
            ]
        ];

        // Data untuk nominal top-up cepat
        $quickAmounts = [
            10000,
            50000,
            100000,
            150000,
            200000,
            250000
        ];

        return view('topup', compact('paymentMethods', 'quickAmounts'));
    }

    public function process(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:10000|max:10000000',
            'payment_method' => 'required|string',
        ], [
            'amount.required' => session('locale') == 'en' ? 'Amount is required' : 'Nominal harus diisi',
            'amount.numeric' => session('locale') == 'en' ? 'Amount must be a number' : 'Nominal harus berupa angka',
            'amount.min' => session('locale') == 'en' ? 'Minimum amount is Rp 10.000' : 'Minimal top up Rp 10.000',
            'amount.max' => session('locale') == 'en' ? 'Maximum amount is Rp 10.000.000' : 'Maksimal top up Rp 10.000.000',
            'payment_method.required' => session('locale') == 'en' ? 'Payment method is required' : 'Metode pembayaran harus dipilih',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Redirect ke halaman instruksi pembayaran
        return redirect()->route('topup.instruction', [
            'amount' => $request->amount,
            'method' => $request->payment_method
        ]);
    }

    public function instruction(Request $request)
    {
        $amount = $request->get('amount');
        $selectedMethod = $request->get('method');

        // Validasi parameter
        if (!$amount || !$selectedMethod) {
            return redirect()->route('topup')->with('error', 'Invalid payment data');
        }

        // Data untuk metode pembayaran
        $paymentMethods = [
            [
                'id' => 'bca',
                'name' => 'Bank Central Asia',
                'code' => 'BCA',
                'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/5/5c/Bank_Central_Asia.svg/200px-Bank_Central_Asia.svg.png'
            ],
            [
                'id' => 'mandiri',
                'name' => 'Mandiri',
                'code' => 'MANDIRI',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/200px-Bank_Mandiri_logo_2016.svg.png'
            ],
            [
                'id' => 'bri',
                'name' => 'BRI',
                'code' => 'BRI',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/200px-BANK_BRI_logo.svg.png'
            ],
            [
                'id' => 'qris',
                'name' => 'QRIS',
                'code' => 'QRIS',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/de/QRIS_logo.svg/200px-QRIS_logo.svg.png'
            ]
        ];

        return view('topup.instruction', compact('amount', 'selectedMethod', 'paymentMethods'));
    }

    public function success()
    {
        // Tampilkan halaman sukses
        return view('topup.success');
    }
}
