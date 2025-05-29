<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Logic untuk mengambil data dashboard
        $donationBalance = 500000; // Simulasi saldo donasi
        
        // Data campaign terbaru
        $latestCampaigns = [
            [
                'id' => 1,
                'title' => 'Bantu Korban Banjir Jakarta',
                'category' => 'Bencana Alam',
                'image' => 'https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=400&h=300&fit=crop',
                'collected' => 15000000,
                'progress' => 75
            ],
            [
                'id' => 2,
                'title' => 'Operasi Jantung Anak',
                'category' => 'Kesehatan',
                'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop',
                'collected' => 8500000,
                'progress' => 42
            ],
            [
                'id' => 3,
                'title' => 'Bantuan Pendidikan Anak Yatim',
                'category' => 'Pendidikan',
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=400&h=300&fit=crop',
                'collected' => 12000000,
                'progress' => 60
            ]
        ];
        
        // Data campaign selesai
        $finishedCampaigns = [
            [
                'id' => 4,
                'title' => 'Bantuan Gempa Lombok',
                'image' => 'https://images.unsplash.com/photo-1574169208507-84376144848b?w=300&h=200&fit=crop'
            ],
            [
                'id' => 5,
                'title' => 'Operasi Katarak Lansia',
                'image' => 'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=300&h=200&fit=crop'
            ],
            [
                'id' => 6,
                'title' => 'Beasiswa Anak Kurang Mampu',
                'image' => 'https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=300&h=200&fit=crop'
            ],
            [
                'id' => 7,
                'title' => 'Bantuan Pangan Ramadan',
                'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=300&h=200&fit=crop'
            ]
        ];

        return view('dashboard', compact('donationBalance', 'latestCampaigns', 'finishedCampaigns'));
    }
}
