<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Subject;
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
        Student::factory(10)->create();
        Classroom::factory()->create(
            [
                'name' => '10A',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10B',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10C',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10D',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '10E',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11A',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11B',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11C',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '11D',
                'capacity' => 30,
            ]
        );

        Classroom::factory()->create(
            [
                'name' => '11E',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12A',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12B',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12C',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12D',
                'capacity' => 30,
            ]
        );
        Classroom::factory()->create(
            [
                'name' => '12E',
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
        Schedule::factory(20)->create();
    }
}
