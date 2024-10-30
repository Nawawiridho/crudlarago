<?php

namespace App\Http\Controllers;

use App\Services\BarangService;
use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;

class getAllController extends Controller
{
    protected $barangService;

    public function __construct(BarangService $barangService)
    {
        $this->barangService = $barangService;
    }

    public function index()
    {
        $getall = $this->barangService->GetALL();
        // return ($getall);
        return view('monitoring.index', compact('getall'));
    }
}
