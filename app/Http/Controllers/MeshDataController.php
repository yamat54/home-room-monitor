<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MeshData;

class MeshDataController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->input();
        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 24;
        $offset = $page > 1 ? ($page - 1) * $limit : 0;

        $meshData = new MeshData();
        $data = $meshData->findAll($offset, $limit);

        $max_page = 10;

        return view('mesh_data.index', compact('data','page','max_page'));
    }
}
