# PemLanjut - User Management System

## Description
PemLanjut is a simple PHP-based user management system with authentication and role-based access control. It allows users to log in and access a dashboard with different views for admins and regular users. Admins can manage users by creating, updating, and deleting user accounts, including uploading profile photos. Regular users can update their own profile information.

## Features
- User authentication with session management
- Role-based access control (admin and user)
- Admin dashboard to manage users (CRUD operations)
- User dashboard with profile update functionality
- Password hashing for security
- File upload support for user profile photos
- Responsive UI using Bootstrap 4

## Technologies Used
- PHP
- MySQL (using MySQLi extension)
- Bootstrap 4 for frontend styling

## Setup Instructions
1. Clone or download the project files to your web server directory (e.g., `c:/laragon/www/PemLanjut`).
2. Create a MySQL database named `crud`.
3. Import the database schema and tables (not provided in this project, you need to create a `tb_user` table with appropriate fields).
4. Update the database connection settings in `connMysqli.php` if necessary:
   ```php
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "crud";
   ```
5. Ensure the `uploads/` directory exists and is writable for storing user photos.
6. Access the application via your web browser at the project URL (e.g., `http://localhost/PemLanjut/index.php`).

## Usage
- Users must log in via the login page (`interface/login.php`).
- After login, users are redirected to the dashboard (`index.php`).
- Admin users can access the user management page (`interface/admin.php`) to add, edit, or delete users.
- Regular users can view their dashboard and update their profile (`interface/user.php`).
- Users can log out via the logout link (`logout.php`).

## Notes
- Passwords are securely hashed using PHP's `password_hash` function.
- Uploaded photos are stored in the `uploads/` directory. If no photo is uploaded, a default image is used.
- Access control is enforced via session checks in controller files.
- The project uses Bootstrap 4 CDN for styling.

## License
This project is provided as-is without any warranty.
