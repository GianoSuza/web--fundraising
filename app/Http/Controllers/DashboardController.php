<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirestoreService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $firestoreService;

    public function __construct(FirestoreService $firestoreService)
    {
        $this->firestoreService = $firestoreService;
    }

    public function index()
    {
        // Get current user data from session or Firestore
        $user = Auth::user();
        $userData = session('user_data');
        
        if (!$userData && $user) {
            $userData = $this->firestoreService->getUserByEmail($user->email);
            if ($userData) {
                session(['user_data' => $userData['data']]);
                $userData = $userData['data'];
            }
        }
        
        $donationBalance = $userData['saldo'] ?? 0;

        // Get latest campaigns from donations collection
        $donationsRef = $this->firestoreService->getCollection('donations');
        $latestCampaigns = [];
        $finishedCampaigns = [];

        try {
            // Get latest active campaigns (where finishDate is in the future)
            $now = new \Google\Cloud\Core\Timestamp(new \DateTime());
            $latestCampaignsQuery = $donationsRef->where('finishDate', '>', $now)
                ->orderBy('createdAt', 'desc');
            
            foreach ($latestCampaignsQuery->documents() as $doc) {
                $data = $doc->data();
                $latestCampaigns[] = [
                    'id' => $doc->id(),
                    'title' => $data['name'] ?? 'Untitled Campaign',
                    'category' => $data['category'] ?? 'Uncategorized',
                    'image' => !empty($data['imageUrls']) ? $data['imageUrls'][0] : 'images/default-campaign.jpg',
                    'collected' => $data['progress'] ?? 0,
                    'progress' => isset($data['progress'], $data['target']) 
                        ? ($data['progress'] / $data['target']) * 100 
                        : 0
                ];
            }

            // Get finished campaigns (where finishDate is in the past)
            $finishedCampaignsQuery = $donationsRef->where('finishDate', '<=', $now)
                ->orderBy('createdAt', 'desc');
            
            foreach ($finishedCampaignsQuery->documents() as $doc) {
                $data = $doc->data();
                $finishedCampaigns[] = [
                    'id' => $doc->id(),
                    'title' => $data['name'] ?? 'Untitled Campaign',
                    'image' => !empty($data['imageUrls']) ? $data['imageUrls'][0] : 'images/default-campaign.jpg'
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching campaigns: ' . $e->getMessage());
            
            // If index is not ready, fallback to simple query
            if (strpos($e->getMessage(), 'requires an index') !== false) {
                \Log::info('Falling back to simple query without ordering');
                
                // Fallback query without ordering
                $latestCampaignsQuery = $donationsRef->where('finishDate', '>', $now);
                
                foreach ($latestCampaignsQuery->documents() as $doc) {
                    $data = $doc->data();
                    $latestCampaigns[] = [
                        'id' => $doc->id(),
                        'title' => $data['name'] ?? 'Untitled Campaign',
                        'category' => $data['category'] ?? 'Uncategorized',
                        'image' => !empty($data['imageUrls']) ? $data['imageUrls'][0] : 'images/default-campaign.jpg',
                        'collected' => $data['progress'] ?? 0,
                        'progress' => isset($data['progress'], $data['target']) 
                            ? ($data['progress'] / $data['target']) * 100 
                            : 0
                    ];
                }

                // Fallback for finished campaigns
                $finishedCampaignsQuery = $donationsRef->where('finishDate', '<=', $now);
                
                foreach ($finishedCampaignsQuery->documents() as $doc) {
                    $data = $doc->data();
                    $finishedCampaigns[] = [
                        'id' => $doc->id(),
                        'title' => $data['name'] ?? 'Untitled Campaign',
                        'image' => !empty($data['imageUrls']) ? $data['imageUrls'][0] : 'images/default-campaign.jpg'
                    ];
                }
            } else {
                // If it's a different error, throw it
                throw $e;
            }
        }

        \Log::info('Latest campaigns count: ' . count($latestCampaigns));
        \Log::info('Finished campaigns count: ' . count($finishedCampaigns));

        return view('dashboard', compact('donationBalance', 'latestCampaigns', 'finishedCampaigns'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');
        
        if (strlen($query) < 3 && !$category) {
            return response()->json([]);
        }

        $donationsRef = $this->firestoreService->getCollection('donations');
        $searchQuery = $donationsRef;

        // Apply category filter if provided
        if ($category) {
            $searchQuery = $searchQuery->where('category', '=', $category);
        }

        // Apply search query if provided
        if (strlen($query) >= 3) {
            // Search in both name and description
            $searchQuery = $searchQuery->where(function($q) use ($query) {
                $q->where('name', '>=', $query)
                  ->where('name', '<=', $query . '\uf8ff')
                  ->orWhere('description', '>=', $query)
                  ->where('description', '<=', $query . '\uf8ff');
            });
        }

        // Get all matching campaigns
        $results = [];
        foreach ($searchQuery->documents() as $doc) {
            $data = $doc->data();
            $results[] = [
                'id' => $doc->id(),
                'title' => $data['name'] ?? 'Untitled Campaign',
                'category' => $data['category'] ?? 'Uncategorized',
                'image' => !empty($data['imageUrls']) ? $data['imageUrls'][0] : 'images/default-campaign.jpg',
                'collected' => $data['progress'] ?? 0,
                'progress' => isset($data['progress'], $data['target']) 
                    ? ($data['progress'] / $data['target']) * 100 
                    : 0
            ];
        }

        return response()->json($results);
    }
}
