<?php

namespace App\Http\Controllers;

use App\Services\ItemService;
use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        $items = $this->itemService->getItems();

        return view('items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'price' => (string)$request->input('price'),
        ];

        try {
            $response = $this->itemService->createItem($data);

            // return redirect()->route('items.index')->with('success', $response['message']);
            return redirect()->route('items.index')->with('success', 'Data berhasil disimpan');

        } catch (RequestException $e) {

            return redirect()->route('items.index')->with('error', 'Gagal membuat item. Silakan coba lagi.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->input('name'),
            'price' => (string)$request->input('price'),
        ];

        try {
            $response = $this->itemService->updateItem($id, $data);
            return redirect()->route('items.index')->with('success', 'Item berhasil diupdate');
        } catch (RequestException $e) {
            return redirect()->route('items.index')->with('error', 'Gagal mengupdate item. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->itemService->deleteItem($id);
            // Tambahkan pesan sukses ke session setelah berhasil dihapus
            return redirect()->route('items.index')->with('success', 'Item berhasil dihapus');
        } catch (RequestException $e) {
            // Jika ada error, tambahkan pesan error
            return redirect()->route('items.index')->with('error', 'Gagal menghapus item');
        }
    }

}
