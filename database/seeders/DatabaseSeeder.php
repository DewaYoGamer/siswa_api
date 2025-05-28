<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10A',
                'grade' => '10',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10B',
                'grade' => '10',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10C',
                'grade' => '10',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10D',
                'grade' => '10',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10E',
                'grade' => '10',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11A',
                'grade' => '11',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11B',
                'grade' => '11',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11C',
                'grade' => '11',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11D',
                'grade' => '11',
                'capacity' => 30,
            ]
        );

        Classroom::factory()->create(
            [
                'name' => '11E',
                'grade' => '11',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12A',
                'grade' => '12',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12B',
                'grade' => '12',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12C',
                'grade' => '12',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12D',
                'grade' => '12',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12E',
                'grade' => '12',
                'capacity' => 30,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Matematika',
                'is_mandatory' => true,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Bahasa Inggris',
                'is_mandatory' => true,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Bahasa Indonesia',
                'is_mandatory' => true,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Biologi',
                'is_mandatory' => false,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Kimia',
                'is_mandatory' => false,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Fisika',
                'is_mandatory' => false,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Ekonomi',
                'is_mandatory' => false,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Geografi',
                'is_mandatory' => false,
            ]
        );
        Subject::factory()->create(
            [
                'name' => 'Seni Budaya',
                'is_mandatory' => false,
            ]
        );
        Teacher::factory()->create(
            [
                'name' => 'Budi Santoso'
            ]
        );
        Teacher::factory()->create(
            [
                'name' => 'Siti Aminah'
            ]
        );
        Teacher::factory()->create(
            [
                'name' => 'Dewi Sartika'
            ]
        );
        Teacher::factory()->create(
            [
                'name' => 'Rina Suryani'
            ]
        );
        Teacher::factory()->create(
            [
                'name' => 'Agus Salim'
            ]
        );
        Schedule::factory()->create(
            [
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'classroom_id' => 6,
                'subject_id' => 2,
                'teacher_id' => 1,
            ]
        );
        Schedule::factory()->create(
            [
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'classroom_id' => 7,
                'subject_id' => 3,
                'teacher_id' => 2,
            ]
        );
        Schedule::factory()->create(
            [
                'start_time' => '12:00:00',
                'end_time' => '13:30:00',
                'classroom_id' => 8,
                'subject_id' => 4,
                'teacher_id' => 3,
            ]
        );
        Schedule::factory()->create(
            [
                'start_time' => '14:00:00',
                'end_time' => '15:30:00',
                'classroom_id' => 9,
                'subject_id' => 5,
                'teacher_id' => 4,
            ]
        );
        Schedule::factory()->create(
            [
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'classroom_id' => 10,
                'subject_id' => 6,
                'teacher_id' => 5,
            ]
        );
    }
}
