<?php

namespace App\Http\Controllers;

use App\Services\BarangService;
use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;

class BarangController extends Controller
{
    protected $barangService;

    public function __construct(BarangService $barangService)
    {
        $this->barangService = $barangService;
    }


    public function index()
    {
        $barang = $this->barangService->GetBarang();
        // return ($barang);
        return view('barang.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $data = [
            'nama_barang' => $request->input('name'),
            'stok' => (int)$request->input('price'),
            'id_jenis' => (int)$request->input('jenisbarang'),
        ];

        try {
            $response = $this->barangService->CreateBarang($data);

            // return redirect()->route('barang.index')->with('success', $response['message']);
            return redirect()->route('barang.index')->with('success', 'Data berhasil disimpan');

        } catch (RequestException $e) {

            return redirect()->route('barang.index')->with('error', 'Gagal membuat item. Silakan coba lagi.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nama_barang' => $request->input('namabarang'),
            'stok' => (int)$request->input('stok'),
        ];
        // print_r($data);die;

        try {
            $response = $this->barangService->UpdateBarang($id, $data);
            return redirect()->route('barang.index')->with('success', 'Item berhasil diupdate');
        } catch (RequestException $e) {
            return redirect()->route('barang.index')->with('error', 'Gagal mengupdate Barang. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->barangService->DeleteBarang($id);
            
            return redirect()->route('barang.index')->with('success', 'Item berhasil dihapus');
        } catch (RequestException $e) {
            
            return redirect()->route('barang.index')->with('error', 'Gagal menghapus item');
        }
    }
}
