<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StudentSchedule;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['user', 'schedules.classroom', 'schedules.subject', 'schedules.teacher'])->get();
        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $student = Student::create([
            'nisn' => $request->nisn,
            'user_id' => $user->id,
        ]);

        $schedules = Schedule::with(['subject'])->whereHas('subject', function ($query) {
            $query->where('is_mandatory', true);
        })->get();
        if ($schedules->isNotEmpty()) {
            foreach ($schedules as $schedule) {
                $studentSchedule = new StudentSchedule();
                $studentSchedule->student_id = $student->id;
                $studentSchedule->schedule_id = $schedule->id;
                $studentSchedule->save();
            }
        }

        return new StudentResource($student->load(['user']));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:students,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $student = Student::with(['user', 'schedules'])->findOrFail($id)->load(['user', 'schedules.subject', 'schedules.teacher']);
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::with(['user'])->findOrFail($id);
        $student->user->update($request->only('name', 'email', 'password'));
        $student->update($request->only('nisn'));

        return new StudentResource($student->load(['user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:students,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $student = Student::with(['user'])->findOrFail($id);
        $student->user->delete();
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
