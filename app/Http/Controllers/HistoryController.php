<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        // Data untuk riwayat transaksi (biasanya dari database)
        $transactions = [
            'this_month' => [
                [
                    'id' => 1,
                    'type' => 'topup',
                    'title' => session('locale') == 'en' ? 'Top up balance' : 'Top up saldo',
                    'amount' => 50000,
                    'date' => '2024-04-05',
                    'status' => 'completed'
                ],
                [
                    'id' => 2,
                    'type' => 'donation',
                    'title' => session('locale') == 'en' ? 'Natural Disaster Aceh' : 'Bencana Alam Aceh',
                    'amount' => -25000,
                    'date' => '2024-04-04',
                    'status' => 'completed'
                ],
                [
                    'id' => 3,
                    'type' => 'donation',
                    'title' => session('locale') == 'en' ? 'Build Mosque' : 'Bangun Masjid',
                    'amount' => -25000,
                    'date' => '2024-04-04',
                    'status' => 'completed'
                ],
                [
                    'id' => 4,
                    'type' => 'topup',
                    'title' => session('locale') == 'en' ? 'Top up balance' : 'Top up saldo',
                    'amount' => 50000,
                    'date' => '2024-04-03',
                    'status' => 'completed'
                ],
                [
                    'id' => 5,
                    'type' => 'donation',
                    'title' => session('locale') == 'en' ? 'Build Mosque' : 'Bangun Masjid',
                    'amount' => -10000,
                    'date' => '2024-04-01',
                    'status' => 'completed'
                ]
            ],
            'march_2024' => [
                [
                    'id' => 6,
                    'type' => 'donation',
                    'title' => session('locale') == 'en' ? 'Flood Demak' : 'Banjir Demak',
                    'amount' => -50000,
                    'date' => '2024-03-29',
                    'status' => 'completed'
                ],
                [
                    'id' => 7,
                    'type' => 'donation',
                    'title' => session('locale') == 'en' ? 'Social assistance' : 'Bantuan sosial',
                    'amount' => -50000,
                    'date' => '2024-03-29',
                    'status' => 'completed'
                ],
                [
                    'id' => 8,
                    'type' => 'topup',
                    'title' => session('locale') == 'en' ? 'Top up balance' : 'Top up saldo',
                    'amount' => 110000,
                    'date' => '2024-03-25',
                    'status' => 'completed'
                ]
            ]
        ];

        return view('history', compact('transactions'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        // Logic untuk mencari transaksi berdasarkan query
        // Biasanya menggunakan database query dengan LIKE atau full-text search
        
        // Simulasi hasil pencarian
        $results = [];
        
        return response()->json(['results' => $results]);
    }
}
