<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $url = env('NEWS_API_URL');
        $apiKey = env('NEWS_API_KEY');
        $query = request('query', 'tesla');

        $params = [
            'q' => $query,
            'from' => '2024-08-10',
            'sortBy' => 'publishedAt',
            'apiKey' => $apiKey
        ];

        $response = Http::get($url, $params);

        if ($response->successful()) {
            $newsData = $response->json();
            $articles = $newsData['articles'];

            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 16;
            $currentItems = array_slice($articles, ($currentPage - 1) * $perPage, $perPage);
            $paginator = new LengthAwarePaginator($currentItems, count($articles), $perPage, $currentPage, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);

            return view('tesla_news', ['newsData' => $newsData, 'paginator' => $paginator]);
        } else {
            $newsData = [
                'status' => 'error',
                'message' => 'Não foi possível obter as notícias.'
            ];
            return view('tesla_news', ['newsData' => $newsData]);
        }
    }

    public function show($data)
    {
        $data = Crypt::decryptString($data);
        $article = json_decode($data, true);

        return view('detail_news', $article);
    }
}

