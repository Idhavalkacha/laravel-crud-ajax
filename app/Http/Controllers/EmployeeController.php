<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return view('search', ['employee' => $employee]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('image')) {
            $request->merge(['images' => $request->image->getClientOriginalName()]);
            $image = $request->file('image');
//            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $fileName = $image->getClientOriginalName();
            $image->storeAs('public/images', $fileName);
        }
        $employee = Employee::create($request->except(['image']));
        if (isset($employee)) {
            return response()->json([
                'status' => 200,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        if ($request->has('image')) {
            $request->merge(['images' => $request->image->getClientOriginalName()]);
            $image = $request->file('image');
//            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $fileName = $image->getClientOriginalName();
            $image->storeAs('public/images', $fileName);
        }
        $employee = $employee->update($request->except(['image']));
        if (isset($employee)) {
            return response()->json([
                'status' => 200,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee = $employee->delete();
        if ($employee) {
            return response()->json([
                'status' => 200
            ]);
        }
    }
}
