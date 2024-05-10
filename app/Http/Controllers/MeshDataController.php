<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeshData;
use Carbon\Carbon;

class MeshDataController extends Controller
{
    public function index(Request $request)
    {
        // デフォルトの日付範囲を設定
        $time_start = $request->get('time_start', now()->addDays(-7)->format('Y-m-d'));
        $time_end = $request->get('time_end', now()->format('Y-m-d'));

        // ページネーションの設定
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 24);
        $offset = ($page - 1) * $limit;

        // フィルターの設定
        $filters = [
            'time_start' => $time_start,
            'time_end' => $time_end,
        ];

        // データの取得とページネーション
        $data = MeshData::whereBetween('created_at', [$time_start . ' 00:00:00', $time_end . ' 23:59:59'])->offset($offset)->limit($limit)->get();

        // 総ページ数の計算
        $total = MeshData::whereBetween('created_at', [$time_start . ' 00:00:00', $time_end . ' 23:59:59'])->count();
        $page_max = ceil($total / $limit);

        // 前後のページ番号
        $page_prev = ($page > 1) ? $page - 1 : null;
        $page_next = ($page < $page_max) ? $page + 1 : null;

        // ビューにデータを渡す
        return view('mesh_data.index', compact('time_start', 'time_end', 'page', 'data', 'page_max', 'page_prev', 'page_next'));
    }
}
