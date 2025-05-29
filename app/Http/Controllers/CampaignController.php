<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function detail($id)
    {
        // Simulasi data campaign berdasarkan ID
        $campaigns = [
            1 => [
                'id' => 1,
                'title' => 'Bantu Korban Banjir Jakarta',
                'description' => 'Banjir besar melanda Jakarta dan sekitarnya. Ribuan keluarga kehilangan tempat tinggal dan membutuhkan bantuan segera untuk kebutuhan dasar seperti makanan, air bersih, dan tempat tinggal sementara.',
                'category' => 'Bencana Alam',
                'image' => 'https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=800&h=600&fit=crop',
                'target' => 20000000,
                'collected' => 15000000,
                'progress' => 75,
                'location' => 'Jakarta',
                'days_left' => 15,
                'views' => 1250,
                'organizer' => [
                    'name' => 'Sakie.Helpin',
                    'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face',
                    'verified' => true
                ],
                'story' => 'Banjir yang melanda Jakarta pada minggu ini telah menyebabkan ribuan keluarga kehilangan tempat tinggal. Mereka sangat membutuhkan bantuan untuk kebutuhan dasar seperti makanan, air bersih, pakaian, dan tempat tinggal sementara. Setiap donasi yang Anda berikan akan langsung disalurkan kepada korban banjir melalui relawan terpercaya di lapangan.',
                'updates' => [
                    [
                        'date' => '2024-04-05',
                        'title' => 'Distribusi bantuan hari ke-3',
                        'content' => 'Hari ini tim relawan berhasil mendistribusikan 500 paket makanan dan 200 botol air mineral kepada korban banjir di wilayah Kemang.'
                    ],
                    [
                        'date' => '2024-04-04',
                        'title' => 'Bantuan logistik tiba',
                        'content' => 'Alhamdulillah bantuan berupa makanan siap saji dan air bersih telah tiba di posko utama. Terima kasih untuk semua donatur yang telah membantu.'
                    ]
                ]
            ],
            2 => [
                'id' => 2,
                'title' => 'Operasi Jantung Anak',
                'description' => 'Anak berusia 8 tahun membutuhkan operasi jantung segera. Keluarga tidak mampu membiayai operasi yang membutuhkan biaya sangat besar ini.',
                'category' => 'Kesehatan',
                'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&h=600&fit=crop',
                'target' => 20000000,
                'collected' => 8500000,
                'progress' => 42,
                'location' => 'Surabaya',
                'days_left' => 30,
                'views' => 890,
                'organizer' => [
                    'name' => 'Yayasan Peduli Anak',
                    'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
                    'verified' => true
                ],
                'story' => 'Adik kecil bernama Budi berusia 8 tahun menderita penyakit jantung bawaan yang memerlukan operasi segera. Keluarga Budi adalah keluarga sederhana yang tidak mampu membiayai operasi yang membutuhkan biaya puluhan juta rupiah. Bantuan Anda sangat berarti untuk menyelamatkan nyawa Budi.',
                'updates' => [
                    [
                        'date' => '2024-04-03',
                        'title' => 'Konsultasi dengan dokter spesialis',
                        'content' => 'Budi telah menjalani konsultasi dengan dokter spesialis jantung anak. Dokter menyatakan operasi harus segera dilakukan dalam 2 bulan ke depan.'
                    ]
                ]
            ],
            3 => [
                'id' => 3,
                'title' => 'Bantuan Pendidikan Anak Yatim',
                'description' => 'Program beasiswa untuk anak-anak yatim agar dapat melanjutkan pendidikan hingga jenjang yang lebih tinggi.',
                'category' => 'Pendidikan',
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&h=600&fit=crop',
                'target' => 20000000,
                'collected' => 12000000,
                'progress' => 60,
                'location' => 'Bandung',
                'days_left' => 45,
                'views' => 2100,
                'organizer' => [
                    'name' => 'Rumah Yatim Indonesia',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
                    'verified' => true
                ],
                'story' => 'Pendidikan adalah hak setiap anak, termasuk anak-anak yatim. Program ini bertujuan memberikan beasiswa pendidikan untuk 50 anak yatim agar mereka dapat melanjutkan sekolah dan meraih cita-cita mereka. Dengan bantuan Anda, mereka dapat memiliki masa depan yang lebih cerah.',
                'updates' => [
                    [
                        'date' => '2024-04-01',
                        'title' => 'Penyaluran beasiswa semester ini',
                        'content' => '25 anak yatim telah menerima beasiswa untuk semester ini. Mereka sangat antusias untuk kembali bersekolah.'
                    ]
                ]
            ]
        ];

        // Ambil data campaign berdasarkan ID
        $campaign = $campaigns[$id] ?? null;

        if (!$campaign) {
            return redirect()->route('dashboard')->with('error', 'Campaign not found');
        }

        return view('campaigns.detail', compact('campaign'));
    }

    public function donate($id)
    {
        // Redirect ke halaman donasi dengan ID campaign
        return redirect()->route('donate', ['campaign_id' => $id]);
    }
}
