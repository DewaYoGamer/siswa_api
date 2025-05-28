# School Management System API

A comprehensive school management system built with Laravel 11, featuring student management, scheduling, classroom administration, and role-based access control.

## 🚀 Features

-   **User Authentication & Authorization** with Laravel Sanctum
-   **Role-based Access Control** (Admin, Student)
-   **Student Management** with profile management
-   **Schedule Management** with classroom and teacher assignments
-   **Classroom Administration** with capacity management
-   **Subject & Teacher Management**
-   **RESTful API** with comprehensive endpoints
-   **Data Validation** and error handling
-   **Resource Transformers** for consistent API responses

## 📋 Table of Contents

-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Database Setup](#database-setup)
-   [API Documentation](#api-documentation)
-   [Authentication](#authentication)
-   [User Roles](#user-roles)
-   [Endpoints](#endpoints)
-   [Testing](#testing)
-   [Contributing](#contributing)
-   [License](#license)

## 🛠 Requirements

-   PHP >= 8.2
-   Composer
-   MySQL/PostgreSQL
-   Laravel 11
-   Laravel Sanctum

## 📦 Installation

1. **Clone the repository:**

    ```bash
    git clone <repository-url>
    cd dalenganjay2
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Copy environment file:**

    ```bash
    cp .env.example .env
    ```

4. **Generate application key:**
    ```bash
    php artisan key:generate
    ```

## ⚙️ Configuration

1. **Database Configuration:**
   Update your `.env` file with database credentials:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

2. **Sanctum Configuration:**
   The application uses Laravel Sanctum for API authentication. Sanctum is already configured in the project.

## 🗄 Database Setup

1. **Run migrations:**

    ```bash
    php artisan migrate
    ```

2. **Seed the database (optional):**
    ```bash
    php artisan db:seed
    ```

## 📖 API Documentation

### Base URL

```
http://localhost:8000/api
```

### Response Format

All API responses follow this structure:

```json
{
    "data": {
        // Response data
    },
    "message": "Success message",
    "errors": {
        // Validation errors (if any)
    }
}
```

## 🔐 Authentication

The API uses **Bearer Token Authentication** with Laravel Sanctum.

### Login Process

1. **Student Registration/Login:**

    ```http
    POST /api/login
    Content-Type: application/json

    {
      "email": "student@example.com",
      "password": "password123"
    }
    ```

2. **Response:**

    ```json
    {
        "id": 1,
        "name": "John Doe",
        "email": "student@example.com",
        "phone": "123456789",
        "token": "1|abcdefg..."
    }
    ```

3. **Using the Token:**
   Include the token in all authenticated requests:
    ```http
    Authorization: Bearer 1|abcdefg...
    ```

## 👥 User Roles

### Admin Role

-   Full access to all resources
-   Can manage students, teachers, subjects, classrooms, and schedules
-   Can activate/deactivate student accounts

### Student Role

-   Access to own profile and schedule information
-   Can view available teachers and schedules
-   Can set personal schedule assignments

## 🛣 Endpoints

### 🔓 Public Endpoints

#### Student Authentication

```http
POST /api/login
POST /api/register
```

**Register Student:**

```http
POST /api/register
Content-Type: application/json

{
  "nisn": "1234567890",
  "grade": 10,
  "parent_name": "Parent Name",
  "parent_phone": "123456789",
  "birth_date": "2005-01-01",
  "religion": "islam",
  "address": "Student Address",
  "gender": "man",
  "phone": "987654321",
  "name": "Student Name",
  "email": "student@example.com",
  "password": "password123"
}
```

### 🔐 Admin Only Endpoints

All admin endpoints require `auth:sanctum` and `check_admin` middleware.

**Base URL:** `/api/admin`

#### Student Management

```http
GET    /api/admin/student           # List all students
GET    /api/admin/student/{id}      # Get specific student
PUT    /api/admin/student/{id}      # Update student
DELETE /api/admin/student/{id}      # Delete student
POST   /api/admin/student_active    # Change student active status
```

**Change Student Active Status:**

```http
POST /api/admin/student_active
Authorization: Bearer {token}
Content-Type: application/json

{
  "id": 1,
  "active": true
}
```

#### Schedule Management

```http
GET    /api/admin/schedule/{id}     # Get specific schedule
POST   /api/admin/schedule          # Create new schedule
PUT    /api/admin/schedule/{id}     # Update schedule
DELETE /api/admin/schedule/{id}     # Delete schedule
```

**Create Schedule:**

```http
POST /api/admin/schedule
Authorization: Bearer {token}
Content-Type: application/json

{
  "classroom_id": 1,
  "subject_id": 1,
  "teacher_id": 1,
  "start_time": "08:00",
  "end_time": "09:30"
}
```

#### Classroom Management

```http
GET    /api/admin/classroom         # List all classrooms
POST   /api/admin/classroom         # Create new classroom
GET    /api/admin/classroom/{id}    # Get specific classroom
PUT    /api/admin/classroom/{id}    # Update classroom
DELETE /api/admin/classroom/{id}    # Delete classroom
```

**Create Classroom:**

```http
POST /api/admin/classroom
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Class 10A",
  "grade": 10,
  "capacity": 30
}
```

#### Subject Management

```http
GET    /api/admin/subject           # List all subjects
POST   /api/admin/subject           # Create new subject
GET    /api/admin/subject/{id}      # Get specific subject
PUT    /api/admin/subject/{id}      # Update subject
DELETE /api/admin/subject/{id}      # Delete subject
```

#### Teacher Management

```http
POST   /api/admin/teacher           # Create new teacher
GET    /api/admin/teacher/{id}      # Get specific teacher
PUT    /api/admin/teacher/{id}      # Update teacher
DELETE /api/admin/teacher/{id}      # Delete teacher
```

### 👨‍🎓 Student Only Endpoints

All student endpoints require `auth:sanctum` and `active_student` middleware.

#### Profile & Schedule

```http
GET  /api/profile                   # Get student profile
GET  /api/schedule                  # Get student schedules
POST /api/set_schedule              # Set student schedule
GET  /api/teacher                   # List all teachers
```

**Set Student Schedule:**

```http
POST /api/set_schedule
Authorization: Bearer {token}
Content-Type: application/json

{
  "student_id": 1,
  "schedule_id": 1
}
```

## 📊 Database Schema

### Users Table

-   `id` - Primary key
-   `name` - User full name
-   `email` - Unique email address
-   `birth_date` - Date of birth
-   `religion` - Religion (islam, christian, hindu, buddhist, catholic, confucianism)
-   `address` - User address
-   `gender` - Gender (man, woman)
-   `phone` - Phone number
-   `role` - User role (admin, student)
-   `active` - Account status (boolean)
-   `password` - Encrypted password

### Students Table

-   `id` - Primary key
-   `nisn` - Student identification number (unique)
-   `grade` - Student grade level
-   `parent_name` - Parent/guardian name
-   `parent_phone` - Parent/guardian phone
-   `user_id` - Foreign key to users table

### Classrooms Table

-   `id` - Primary key
-   `name` - Classroom name
-   `grade` - Grade level
-   `capacity` - Maximum capacity

### Teachers Table

-   `id` - Primary key
-   `user_id` - Foreign key to users table

### Subjects Table

-   `id` - Primary key
-   `name` - Subject name
-   `description` - Subject description

### Schedules Table

-   `id` - Primary key
-   `classroom_id` - Foreign key to classrooms
-   `subject_id` - Foreign key to subjects
-   `teacher_id` - Foreign key to teachers
-   `start_time` - Schedule start time
-   `end_time` - Schedule end time

### Student_Schedules Table (Pivot)

-   `id` - Primary key
-   `student_id` - Foreign key to students
-   `schedule_id` - Foreign key to schedules

## 🧪 Testing

Run the application:

```bash
php artisan serve
```

Test the API endpoints using tools like:

-   **Postman**
-   **Insomnia**
-   **cURL**

### Example cURL Request:

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"student@example.com","password":"password123"}'

# Get profile (with token)
curl -X GET http://localhost:8000/api/profile \
  -H "Authorization: Bearer 1|your-token-here"
```

## 🔧 Middleware

### Custom Middleware

1. **AdminMiddleware** (`check_admin`)

    - Verifies user is authenticated and has admin role
    - Returns 401 if unauthenticated
    - Returns 403 if not admin

2. **ActiveStudentMiddleware** (`active_student`)
    - Verifies user is authenticated, is a student, and account is active
    - Used for student-only endpoints

## 📝 Error Handling

### Common HTTP Status Codes

-   `200` - Success
-   `201` - Created
-   `400` - Bad Request
-   `401` - Unauthenticated
-   `403` - Forbidden (insufficient permissions)
-   `404` - Not Found
-   `422` - Validation Error
-   `500` - Internal Server Error

### Validation Error Response:

```json
{
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
