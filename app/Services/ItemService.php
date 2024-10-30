<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class ItemService
{
    protected $apiUrl;

    public function __construct()
    {
        // URL API Golang Anda
        $this->apiUrl = env('API_BASE_URL') . '/items';
    }

    public function getItems()
    {
        $response = Http::get($this->apiUrl);

        if (!$response->ok()) {
            throw new RequestException($response);
        }

        // Pastikan data diubah menjadi array sebelum dikirim ke controller
        return $response->json();
    }

    public function createItem(array $data)
    {
        $response = Http::post($this->apiUrl, $data);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new RequestException($response);
        }
    }

    public function updateItem($id, array $data)
    {
        $response = Http::put("{$this->apiUrl}/{$id}", $data);
        
        if ($response->successful()) {
            return $response->json();
        } else {
            throw new RequestException($response);
        }
    }


    public function deleteItem($id)
    {
        $response = Http::delete("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new RequestException($response);
        }

    }
}
