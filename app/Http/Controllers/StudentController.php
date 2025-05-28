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
    public function index(Request $request){
        $user = auth()->user();
        if ($user->role !== 'admin') {
            $students = Student::with(['user', 'schedules.classroom', 'schedules.subject', 'schedules.teacher'])
                ->where('user_id', $user->id)
                ->get();
            return StudentResource::collection($students);
        }
        $students = Student::with(['user', 'schedules.classroom', 'schedules.subject', 'schedules.teacher'])->get();
        return StudentResource::collection($students);
    }

    public function profile(Request $request){
        $user = auth()->user();
        $student = Student::with(['user', 'schedules.classroom', 'schedules.subject', 'schedules.teacher'])
            ->where('user_id', $user->id)
            ->first();
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return new StudentResource($student);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|max:255|unique:students,nisn',
            'grade' => 'required|integer',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'religion' => 'nullable|in:islam,christian,hindu,buddhist,catholic,confucianism',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:man,woman',
            'phone' => 'nullable|string|max:20',
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
            'birth_date' => $request->birth_date,
            'religion' => $request->religion,
            'address' => $request->address,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        $student = Student::create([
            'nisn' => $request->nisn,
            'grade' => $request->grade,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'user_id' => $user->id,
        ]);

        return new StudentResource($student->load(['user']));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
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
    public function update(Request $request, string $id){
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
    public function destroy(string $id){
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

    public function login(Request $request){
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
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'token' => $token,
        ]);
    }

    public function changeActive(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:students,id',
            'active' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $student = Student::findOrFail($request->id);
        $student->user->active = $request->active;
        $student->user->save();
        return response()->json(['message' => 'User active status updated successfully']);
    }
}
