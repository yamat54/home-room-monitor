<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MeshData;

class MeshDataController extends Controller
{
    public function index(Request $request)
    {
        $time_start = $request->get('time_start', now()->addDays(-7)->format('Y-m-d'));
        $time_end = $request->get('time_end', now()->format('Y-m-d'));
        if (empty($time_start) && empty($time_end)) {
            $time_start = now()->addDays(-7)->format('Y-m-d');
            $time_end = now()->format('Y-m-d');
        }
        $page = $request->get('page') ? : 1;
        $limit = $request->get('limit') ? : 24;
        $offset = $page > 1 ? ($page - 1) * $limit : 0;
        $filters = [
            'time_start' => $time_start,
            'time_end' => $time_end,
        ];

        $meshData = new MeshData();
        $data = $meshData->findSearch($filters, $offset, $limit);
        $page_max = ceil(count($meshData->findSearch($filters)) / $limit);
        $page_prev = ($page > 1) ? $page - 1 : 0;
        $page_next = ($page < $page_max) ? $page + 1 : 0;

        return view('mesh_data.index', compact('time_start','time_end','page','data','page_max','page_prev','page_next'));
    }
}
