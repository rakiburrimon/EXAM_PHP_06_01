<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\
{
    Request, JsonResponse,
};

class OfficeController extends Controller
{
    /**
     * Display a listing of the offices.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View|JsonResponse
     */
    public function index(Request $request): \Illuminate\View\View|JsonResponse
    {
        $offices = Office::withCount('colleagues')->get();

        $data['offices'] = $offices;

        if ($request->ajax()) {
            return response()->json($offices);
        }

        return view('offices.index', $data);
    }
}
