# Fast-Food Payroll System

## Project Structure

```
/api-payroll/
├── frontend/                  # All HTML/JS frontend files
│   ├── admin/                 # Admin pages
│   ├── manager/               # Manager pages
│   ├── employee/              # Employee pages
│   ├── shared/                # Login, logout, etc.
│   └── assets/                # CSS, JS, images
├── users/                     # User management API endpoints
│   ├── read-all.php          # List all users
│   ├── create.php            # Create new user
│   ├── update.php            # Update user
│   └── delete.php            # Delete user
├── roles/                     # Role management API endpoints
│   ├── read-all.php          # List all roles
│   └── create.php            # Create role
├── employees/                 # Employee management API endpoints
│   ├── read-all.php          # List all employees
│   ├── create.php            # Create employee
│   └── update.php            # Update employee
├── shifts/                    # Shift management API endpoints
│   ├── read-all.php          # List all shifts
│   ├── read-by-employee.php  # Get employee's shifts
│   ├── create.php            # Create shift
│   ├── update.php            # Update shift
│   └── delete.php            # Delete shift
├── payroll/                   # Payroll management API endpoints
│   ├── read-all.php          # List all payroll records
│   ├── read-by-employee.php  # Get employee's payroll
│   └── create.php            # Create payroll record
├── deductions/                # Deduction management API endpoints
│   ├── read-all.php          # List all deductions
│   ├── read-by-payroll.php   # Get deductions for payroll
│   ├── create.php            # Create deduction
│   ├── update.php            # Update deduction
│   └── delete.php            # Delete deduction
├── payslips/                  # Payslip management API endpoints
│   ├── read-all.php          # List all payslips
│   ├── read-one.php          # Get specific payslip
│   └── create.php            # Create payslip
├── config/                    # Database & core config
├── objects/                   # Database model classes
└── README.md                 # This file
```

## API Architecture

### Individual Endpoint Files
Each entity has its own directory with individual PHP files for each operation:
```
/{entity}/{operation}.php
```

**Examples:**
- `GET /users/read-all.php` → List all users
- `POST /employees/create.php` → Create new employee
- `PUT /shifts/update.php` → Update shift
- `DELETE /users/delete.php` → Delete user

### Object Classes
Each model class contains:
- **Data properties** (public attributes)
- **Database methods** (CRUD operations)
- **No API methods** (removed - now in separate files)

**Example:**
```php
class User {
    // Properties
    public $user_id, $name, $email, $password, $role_id;

    // Database methods only
    public function readAll() { /* ... */ }
    public function create() { /* ... */ }
- **user**: user_id, name, email, password, role_id
- **role**: role_id, role_name (Admin, Manager, Employee)
- **employee**: employee_id, user_id, job_title, hourly_rate
- **shift**: shift_id, employee_id, shift_date, start_time, end_time
- **payroll**: payroll_id, employee_id, pay_period, total_hours, gross_pay, net_pay
- **deduction**: deduction_id, payroll_id, deduction_type, amount
- **payslip**: payslip_id, payroll_id, issued_date

## User Roles & Access

### Admin (role_id = 1)
- User management (create, edit, assign roles)
- Role management
- Full system access

### Manager (role_id = 2)
- Employee management (add details, set hourly rates)
- Shift management (create, assign shifts)
- Payroll generation
- Deduction management

### Employee (role_id = 3)
- View personal shifts
- View payroll history
- Download/view payslips

## API Endpoints

### Authentication (Separate)
- `POST /api/auth/login.php` - User login
- `GET /api/auth/check-session.php` - Check current session
- `POST /api/shared/logout.php` - User logout

### Individual API Endpoints

#### Users
- `GET /users/read-all.php` - List all users
- `POST /users/create.php` - Create new user
- `PUT /users/update.php` - Update user
- `DELETE /users/delete.php` - Delete user

#### Roles
- `GET /roles/read-all.php` - List all roles
- `POST /roles/create.php` - Create role

#### Employees
- `GET /employees/read-all.php` - List all employees
- `POST /employees/create.php` - Create employee
- `PUT /employees/update.php` - Update employee

#### Shifts
- `GET /shifts/read-all.php` - List all shifts
- `GET /shifts/read-by-employee.php` - Get employee's shifts
- `POST /shifts/create.php` - Create shift
- `PUT /shifts/update.php` - Update shift
- `DELETE /shifts/delete.php` - Delete shift

#### Payroll
- `GET /payroll/read-all.php` - List all payroll records
- `GET /payroll/read-by-employee.php` - Get employee's payroll
- `POST /payroll/create.php` - Create payroll record

#### Deductions
- `GET /deductions/read-all.php` - List all deductions
- `GET /deductions/read-by-payroll.php` - Get deductions for payroll
- `POST /deductions/create.php` - Create deduction
- `PUT /deductions/update.php` - Update deduction
- `DELETE /deductions/delete.php` - Delete deduction

#### Payslips
- `GET /payslips/read-all.php` - List all payslips
- `GET /payslips/read-one.php` - Get specific payslip
- `POST /payslips/create.php` - Create payslip

## Frontend Pages

### Common Pages
- `/frontend/home.html` - Landing page
- `/frontend/shared/login.html` - Login page
- `/frontend/shared/logout.php` - Logout

### Admin Pages
- `/frontend/admin/dashboard.html` - Admin dashboard
- `/frontend/admin/users.html` - User management
- `/frontend/admin/add-user.html` - Add new user

### Manager Pages
- `/frontend/manager/dashboard.html` - Manager dashboard
- `/frontend/manager/employees.html` - Employee management
- `/frontend/manager/payroll.html` - Payroll generation

### Employee Pages
- `/frontend/employee/dashboard.html` - Employee dashboard
- `/frontend/employee/my-shifts.html` - View assigned shifts
- `/frontend/employee/my-payroll.html` - View payroll history
- `/frontend/employee/payslip.html` - View/download payslips

## Setup Instructions

1. **Import Database**: Import `../payroll_new.sql` into MySQL database (this creates the admin user)
2. Configure database connection in `config/database.php`
3. Access the application through `frontend/shared/login.html`
4. Default admin credentials: admin@payroll.com / password

**Note**: The database import creates the admin user automatically. If you need to recreate the admin user, use `create_admin.html`.

## Development Notes

- All API endpoints return JSON responses
- Frontend uses vanilla JavaScript with fetch API
- Session-based authentication
- Role-based access control
- Hourly-based payroll calculation from shifts
- Individual API endpoint files organized by entity
- Business logic separated from API response handling