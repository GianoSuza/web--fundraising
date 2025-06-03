<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonateController extends Controller
{
    public function index(Request $request, $campaignId)
    {
        if (!$campaignId) {
            return redirect()->route('dashboard')->with('error', 'Campaign not found');
        }

        try {
            // Get Firestore instance
            $firestore = app('firebase.firestore');
            $db = $firestore->database();

            // Get campaign data from Firestore
            $donationRef = $db->collection('donations')->document($campaignId);
            $donation = $donationRef->snapshot();

            if (!$donation->exists()) {
                return redirect()->route('dashboard')->with('error', 'Campaign not found');
            }

            $donationData = $donation->data();
            
            // Format campaign data
            $campaign = [
                'id' => $campaignId,
                'title' => $donationData['name'] ?? 'Untitled Campaign',
                'image' => $donationData['imageUrls'][0] ?? 'https://via.placeholder.com/800x600',
                'target' => $donationData['target'] ?? 0,
                'collected' => $donationData['progress'] ?? 0,
            ];

            // Get user data from session
            $userData = session('user_data');
            if (!$userData) {
                return redirect()->route('dashboard')->with('error', 'User data not found');
            }

            // Get user balance from session
            $userBalance = $userData['saldo'] ?? 0;

            // Quick amount options
            $quickAmounts = [10000, 50000, 100000, 150000, 200000, 250000];

            // Payment methods
            $paymentMethods = [
                [
                    'id' => 'bca',
                    'name' => 'Bank Central Asia',
                    'code' => 'BCA',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1598px-Bank_Central_Asia.svg.png?20200318082802'
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
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/768px-QRIS_logo.svg.png?20201215043119'
                ]
            ];

            return view('donate', compact('campaign', 'quickAmounts', 'paymentMethods', 'userBalance'));
        } catch (\Exception $e) {
            \Log::error('Error fetching campaign details:', [
                'id' => $campaignId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('dashboard')->with('error', 'Failed to load campaign details');
        }
    }

    public function process(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|string',
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

        // Store donation data in session for instruction page
        session([
            'donation_data' => [
                'campaign_id' => $request->campaign_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'type' => 'donation'
            ]
        ]);

        return redirect()->route('donate.instruction');
    }

    public function confirmPayment(Request $request)
    {
        // Get donation data from session
        $donationData = session('donation_data');
        
        if (!$donationData) {
            return redirect()->route('dashboard')->with('error', 'Invalid donation data');
        }

        try {
            // Get Firestore instance
            $firestore = app('firebase.firestore');
            $db = $firestore->database();

            // Get user data from session
            $userData = session('user_data');
            if (!$userData) {
                return redirect()->route('dashboard')->with('error', 'User data not found');
            }

            // Get campaign data
            $donationRef = $db->collection('donations')->document($donationData['campaign_id']);
            $donation = $donationRef->snapshot();

            if (!$donation->exists()) {
                return redirect()->route('dashboard')->with('error', 'Campaign not found');
            }

            $donationData = $donation->data();
            $currentProgress = $donationData['progress'] ?? 0;
            $newProgress = $currentProgress + $donationData['amount'];

            // Update campaign progress
            $donationRef->update([
                ['path' => 'progress', 'value' => $newProgress]
            ]);

            // Create transaction record
            $transactionRef = $db->collection('transactions')->add([
                'userId' => $userData['uid'],
                'campaignId' => $donationData['campaign_id'],
                'amount' => $donationData['amount'],
                'type' => 'donation',
                'status' => 'success',
                'paymentMethod' => $donationData['payment_method'],
                'createdAt' => \Google\Cloud\Core\Timestamp::fromDateTime(new \DateTime())
            ]);

            // Clear donation data from session
            session()->forget('donation_data');

            return redirect()->route('donate.success');
        } catch (\Exception $e) {
            \Log::error('Error processing donation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('dashboard')->with('error', 'Failed to process donation');
        }
    }

    public function instruction(Request $request)
    {
        // Get donation data from session
        $donationData = session('donation_data');
        
        if (!$donationData) {
            return redirect()->route('dashboard')->with('error', 'Invalid donation data');
        }

        try {
            // Get Firestore instance
            $firestore = app('firebase.firestore');
            $db = $firestore->database();

            // Get campaign data
            $donationRef = $db->collection('donations')->document($donationData['campaign_id']);
            $donation = $donationRef->snapshot();

            if (!$donation->exists()) {
                return redirect()->route('dashboard')->with('error', 'Campaign not found');
            }

            $donationData['campaign'] = [
                'id' => $donationData['campaign_id'],
                'title' => $donation->data()['name'] ?? 'Untitled Campaign',
                'image' => $donation->data()['imageUrls'][0] ?? 'https://via.placeholder.com/800x600',
            ];

            // Payment methods data
            $paymentMethods = [
                'bca' => [
                    'name' => 'Bank Central Asia',
                    'account' => '1234567890',
                    'holder' => 'PT Bantu Indonesia'
                ],
                'mandiri' => [
                    'name' => 'Bank Mandiri',
                    'account' => '9876543210',
                    'holder' => 'PT Bantu Indonesia'
                ],
                'bri' => [
                    'name' => 'Bank Rakyat Indonesia',
                    'account' => '5555666677',
                    'holder' => 'PT Bantu Indonesia'
                ]
            ];

            // Get selected payment method details
            $selectedMethod = $paymentMethods[$donationData['payment_method']] ?? null;

            return view('donate.instruction', compact('donationData', 'selectedMethod'));
        } catch (\Exception $e) {
            \Log::error('Error loading instruction page:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('dashboard')->with('error', 'Failed to load instruction page');
        }
    }

    public function success()
    {
        return view('donate.success');
    }
}
