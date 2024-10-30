<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class BarangService
{
    protected $apiUrl;

    public function __construct()
    {
        // URL API Golang Anda
        $this->apiUrl = env('API_BASE_URL');
    }

    public function GetALL()
    {
        $response = Http::get($this->apiUrl. '/getall');

        if (!$response->ok()) {
            throw new RequestException($response);
        }

        // Pastikan data diubah menjadi array sebelum dikirim ke controller
        return $response->json();
    }

    public function GetBarang()
    {
        $response = Http::get($this->apiUrl. '/get_barang');

        if (!$response->ok()) {
            throw new RequestException($response);
        }

        // Pastikan data diubah menjadi array sebelum dikirim ke controller
        return $response->json();
    }

    public function CreateBarang(array $data)
    {
        $response = Http::post($this->apiUrl. '/simpan_barang', $data);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new RequestException($response);
        }
    }

    public function UpdateBarang($id, array $data)
    {
        // print_r($data);die;
        $response = Http::put($this->apiUrl . '/update_barang/' . $id, $data);
        
        if ($response->successful()) {
            return $response->json();
        } else {
            throw new RequestException($response);
        }
    }


    public function DeleteBarang($id)
    {
        // $response = Http::delete("{$this->apiUrl}/{$id}");
        $response = Http::delete($this->apiUrl . '/hapus_barang/' . $id);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new RequestException($response);
        }

    }
}
