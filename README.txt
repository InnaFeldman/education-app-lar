Setting Up the Laravel Project
Follow these steps to set up and run the Laravel project:

1. Create the Database
Start by creating a database named 'laravel'.

2. Install Dependencies
Run the following command to install the required dependencies using Composer: composer install

3. Run Migrations
Execute the migration command to set up the database tables: php artisan migrate

4. Install Passport
Secure your API endpoints by installing Laravel Passport: php artisan passport:install

5. Start the Development Server
Launch the development server to begin testing your application: php artisan serve


Register user:
Object:

{
    "user_name":"testTeacher",
    "email":"testTeacher@test.com",
    "full_name":"Teacher Test",
    "password":"Abc163@$!%?&4",
    "role_id":2
}

Password creation:
- at least 8 characters long;
- contains at least one lowercase letter (a-z);
- contains at least one uppercase letter (A-Z);
- contains at least one digit (0-9);
- may contain special characters (e.g., !@#$%^&*()_+-=[]{}|;:'",.<>?~).


Login User
Object:

{
    "user_name":"testTeacher",
    "password":"Abc163@$!%?&4"
}

CRUD:
1. Student:
Create
{
    "user": {
        "user_name": "Stugdndebj277",
        "full_name": "Sdtgundkjj 277",
        "email": "sgtuddennkjil6676@test.com",
        "password": "45dgnkb6h777",
        "role_id": 1
    },
    "grade": 7,
    "period_id":1
}

Update
{
    "user": {
        "user_name": "StugdndennNEW",
        "full_name": "SdtgundknnNEW",
        "role_id": 1
    },
    "grade": 12
}

Fetch all students by period
{
     "student_id": 1,
     "period_id":2
}

Gets all students by period and by specific teacher
{
     "teacher_id": 1,
     "period_id":2
}

Add student to the period
{
    "student_id": 1,
    "period_id":1
}

Delete student from the period
{
     "student_id": 1,
     "period_id":2
}

2. Teacher:
Create
{
  "user_name": "Techer nn",
  "full_name": "Teache NAme",
  "email": "sgtudtttt6@test.com",
  "password": "425gtttnkb6h777",
  "role_id": 2
}

Edit
{
  "user_name": "Techer n3n4 Update",
  "full_name": "Teache NAme34 Update",
  "role_id": 2
}

3. Period
Create
{
    "name": "Period 1",
    "teacher_id":1
}

Edit

{
    "name": "Period 4 UPd",
    "teacher_id":2
}

