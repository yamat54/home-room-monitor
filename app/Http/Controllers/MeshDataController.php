<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MeshData;

class MeshDataController extends Controller
{
    public function index(Request $request)
    {
        $time = $request->get('time');
        $time = !empty($time) ? $time : now()->format('Y-m-d');
        $filters = [
            'time' => $time,
        ];

        $meshData = new MeshData();
        $data = $meshData->findSearch($filters);

        return view('mesh_data.index', compact('data','time'));
    }
}
