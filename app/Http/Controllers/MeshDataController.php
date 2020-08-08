<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MeshData;

class MeshDataController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->input();
        $offset = isset($params['offset']) ? $params['offset'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 24;

        $meshData = new MeshData();
        $data = $meshData->findAll($offset, $limit);

        return view('mesh_data.index', compact('data'));
    }
}
