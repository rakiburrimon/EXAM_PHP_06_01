<?php

namespace App\Http\Controllers;

use App\Models\Colleague;
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

    /**
     * View a specific office.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id): \Illuminate\View\View
    {
        $data['office'] = Office::withCount('colleagues')->findOrFail($id);

        return view('offices.showofficedetails', $data);
    }

    /**
     * Get the list of colleagues for a specific office.
     *
     * @param  int  $officeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getColleagues($officeId): JsonResponse
    {
        $colleagues = Colleague::where('office_id', $officeId)->get();

        return response()->json($colleagues);
    }
}
