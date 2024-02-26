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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data['office'] = Office::findOrFail($id);
        $data['colleagues'] = Colleague::where('office_id', $id)->get();

        return view('offices.edit', $data);
    }

        /**
     * Update the specified office in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'appointment_letter' => 'nullable|file|max:1024', // 1MB maximum file size
        ]);

        // Find the office by ID
        $office = Office::findOrFail($id);

        // Update office data
        $office->name = $request->name;
        $office->address = $request->address;
        $office->phone = $request->phone;

        // Handle appointment letter file upload
        if ($request->hasFile('appointment_letter')) {
            $appointmentLetter = $request->file('appointment_letter');
            $filename = $appointmentLetter->getClientOriginalName();
            $path = $request->file('appointment_letter')->storeAs('appointment_letters', $filename, 'public');
            $office->appointment_letter = $path;
        }

        // Save the updated office
        $office->save();

        // Return a response
        return response()->json(['message' => 'Office updated successfully']);
    }

    public function colleagueUpdate(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'colleague_name.*' => 'required|string',
            'colleague_phone.*' => 'required|string',
            'colleague_address.*' => 'required|string',
            'colleague_photo.*' => 'image|mimes:jpg,jpeg,png|max:1024', // max size in kilobytes (1MB)
        ]);

        // Loop through each colleague data and update
        foreach ($request->colleague_name as $key => $value) {
            $colleague = Colleague::findOrFail($request->colleague_id[$key]);
            $colleague->name = $request->colleague_name[$key];
            $colleague->phone = $request->colleague_phone[$key];
            $colleague->address = $request->colleague_address[$key];

            // Handle file upload for colleague photo if provided
            if ($request->hasFile('colleague_photo.'.$key)) {
                $file = $request->file('colleague_photo.'.$key);
                $fileName = $file->getClientOriginalName();
                $file->move('uploads/colleague_photos/', $fileName);
                $colleague->photo = $fileName;
            }

            $colleague->save();
        }

        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'Colleagues updated successfully.');
    }

    /**
     * Delete the office with the given ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): \Illuminate\Http\RedirectResponse
    {
        $office = Office::findOrFail($id);
        $colleagues = Colleague::where('office_id', $id);

        // Delete the office
        $office->delete();
        $colleagues->delete();

        // Redirect back or return a response as needed
        return redirect()->route('offices.index')->with('success', 'Office deleted successfully.');
    }
}
