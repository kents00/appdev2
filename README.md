# Student Management System

A simple PHP-based Student Management System (CRUD) using PDO and MySQL.

## Features
- **Create**: Add new students with their name, email, and course.
- **Read**: View a list of all registered students.
- **Update**: Edit existing student information.
- **Delete**: Remove student records with a confirmation prompt.

## Setup
1. Create a database named `school_db`.
2. Create a `students` table:
   ```sql
   CREATE TABLE students (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(100) NOT NULL,
       course VARCHAR(100) NOT NULL
   );
   ```
3. Update `db.php` with your database credentials.
4. Run `index.php` on your local server.

## Modules
### Delete Module
The delete functionality allows users to remove student records. 
- Clicking the "Delete" button triggers a JavaScript confirmation prompt.
- Upon confirmation, the backend `delete.php` script removes the record from the database and redirects back to the index page.
