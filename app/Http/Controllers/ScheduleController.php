<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use App\Models\StudentSchedule;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Subject;
use App\Http\Resources\ScheduleResource;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with(['classroom', 'subject', 'teacher', 'students'])->get();
        return ScheduleResource::collection($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $schedule = Schedule::create($request->all());
        $subject = Subject::findOrFail($request->subject_id);
        if ($subject->is_mandatory) {
            $students = Student::all();
            foreach ($students as $student) {
                $studentSchedule = new StudentSchedule();
                $studentSchedule->student_id = $student->id;
                $studentSchedule->schedule_id = $schedule->id;
                $studentSchedule->save();
            }
        }
        return new ScheduleResource($schedule->load(['classroom', 'subject', 'teacher']));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:schedules,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $schedule = Schedule::with(['classroom', 'subject', 'teacher'])->findOrFail($id);
        return new ScheduleResource($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'classroom_id' => 'sometimes|required|exists:classrooms,id',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i|after:start_time',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        return new ScheduleResource($schedule->load(['classroom', 'subject', 'teacher']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:schedules,id',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }

    public function setStudentSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::findOrFail($request->student_id);
        $schedule = Schedule::findOrFail($request->schedule_id);

        $existingSchedule = StudentSchedule::where('student_id', $student->id)
            ->where('schedule_id', $schedule->id)
            ->first();
        if ($existingSchedule) {
            return response()->json(['message' => 'Schedule already assigned to this student'], 400);
        }

        $studentSchedule = new StudentSchedule();
        $studentSchedule->student_id = $student->id;
        $studentSchedule->schedule_id = $schedule->id;
        $studentSchedule->save();
        return response()->json(['message' => 'Schedule assigned to student successfully']);
    }
}
