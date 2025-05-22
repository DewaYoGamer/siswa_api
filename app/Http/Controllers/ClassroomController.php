<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Classroom;
use App\Models\StudentSchedule;
use App\Http\Models\Schedule;
use App\Http\Resources\ClassroomResource;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClassroomResource::collection(Classroom::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $classroom = Classroom::create($request->all());
        return new ClassroomResource($classroom);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:classrooms,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $classroom = Classroom::findOrFail($id);
        return new ClassroomResource($classroom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'capacity' => 'sometimes|required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->all());
        return new ClassroomResource($classroom);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:classrooms,id',
        ]);
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return response()->json([
            'message' => 'Classroom deleted successfully',
        ]);
    }
}
