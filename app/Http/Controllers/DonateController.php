<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonateController extends Controller
{
    public function index(Request $request)
    {
        $campaignId = $request->get('campaign_id');
        
        if (!$campaignId) {
            return redirect()->route('dashboard')->with('error', 'Campaign not found');
        }

        // Simulasi data campaign - make sure this matches the CampaignController data
        $campaigns = [
            1 => [
                'id' => 1,
                'title' => 'Bantu Korban Banjir Jakarta',
                'image' => 'https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=800&h=600&fit=crop',
                'target' => 20000000,
                'collected' => 15000000,
            ],
            2 => [
                'id' => 2,
                'title' => 'Operasi Jantung Anak',
                'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&h=600&fit=crop',
                'target' => 20000000,
                'collected' => 8500000,
            ],
            3 => [
                'id' => 3,
                'title' => 'Bantuan Pendidikan Anak Yatim',
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&h=600&fit=crop',
                'target' => 20000000,
                'collected' => 12000000,
            ]
        ];

        $campaign = $campaigns[$campaignId] ?? null;
        
        if (!$campaign) {
            return redirect()->route('dashboard')->with('error', 'Campaign not found');
        }

        // Quick amount options
        $quickAmounts = [10000, 50000, 100000, 150000, 200000, 250000];

        // Payment methods
        $paymentMethods = [
            [
                'id' => 'bca',
                'name' => 'Bank Central Asia',
                'logo' => 'https://upload.wikimedia.org/wikipedia/id/thumb/5/5c/Bank_Central_Asia.svg/200px-Bank_Central_Asia.svg.png'
            ],
            [
                'id' => 'mandiri',
                'name' => 'Mandiri',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/200px-Bank_Mandiri_logo_2016.svg.png'
            ],
            [
                'id' => 'bri',
                'name' => 'BRI',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/200px-BANK_BRI_logo.svg.png'
            ],
            [
                'id' => 'qris',
                'name' => 'QRIS',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/de/QRIS_logo.svg/200px-QRIS_logo.svg.png'
            ],
            [
                'id' => 'balance',
                'name' => 'Saldo Bantu.In',
                'logo' => null
            ]
        ];

        // User balance (simulasi)
        $userBalance = 500000;

        return view('donate', compact('campaign', 'quickAmounts', 'paymentMethods', 'userBalance'));
    }

    public function process(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|integer',
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|string',
        ], [
            'campaign_id.required' => 'Campaign ID is required',
            'amount.required' => session('locale') == 'en' ? 'Amount is required' : 'Nominal harus diisi',
            'amount.numeric' => session('locale') == 'en' ? 'Amount must be a number' : 'Nominal harus berupa angka',
            'amount.min' => session('locale') == 'en' ? 'Minimum donation is Rp 10.000' : 'Minimal donasi Rp 10.000',
            'payment_method.required' => session('locale') == 'en' ? 'Payment method is required' : 'Metode pembayaran harus dipilih',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Process donation logic here
        // For now, redirect to success page
        return redirect()->route('donate.success')->with('success', 'Donation successful!');
    }

    public function success()
    {
        return view('donate.success');
    }
}
