<?php
namespace App\Http\Controllers;

use App\Services\JenisBarangService;
use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;

class JenisBarangController extends Controller
{
    protected $jenisbarangService;

    public function __construct(jenisBarangService $jenisbarangService)
    {
        $this->jenisbarangService = $jenisbarangService;
    }


    public function index()
    {
        $jenisbarang = $this->jenisbarangService->GetjenisBarang();
        // return ($jenisbarang);
        return view('jenisbarang.index', compact('jenisbarang'));
    }

    public function store(Request $request)
    {
        $data = [
            'id_jenis' => (int)$request->input('id'),
            'nama_jenis' => $request->input('name'),
        ];

        try {
            $response = $this->jenisbarangService->CreateJenisBarang($data);

            // return redirect()->route('barang.index')->with('success', $response['message']);
            return redirect()->route('jenisbarang.index')->with('success', 'Data berhasil disimpan');

        } catch (RequestException $e) {

            return redirect()->route('jenisbarang.index')->with('error', 'Gagal membuat item. Silakan coba lagi.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nama_jenis' => $request->input('namabarang'),
        ];
        // print_r($data);die;

        try {
            $response = $this->jenisbarangService->UpdateJenisBarang($id, $data);
            return redirect()->route('jenisbarang.index')->with('success', 'Item berhasil diupdate');
        } catch (RequestException $e) {
            return redirect()->route('jenisbarang.index')->with('error', 'Gagal mengupdate Barang. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->jenisbarangService->DeleteJenisBarang($id);
            
            return redirect()->route('jenisbarang.index')->with('success', 'Item berhasil dihapus');
        } catch (RequestException $e) {
            
            return redirect()->route('jenisbarang.index')->with('error', 'Gagal menghapus item');
        }
    }
}
