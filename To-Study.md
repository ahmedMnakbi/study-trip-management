# To-Study

This file explains the structure and important code of the project. Study it before presenting the project.

## 1. Big Picture

The project is a PHP/MySQL web application using a simple MVC architecture.

MVC means:

- Model: communicates with the database.
- View: displays HTML pages.
- Controller: receives user actions and decides what to do.

General request flow:

```text
User clicks a link or submits a form
-> public/index.php receives the request
-> the router chooses a controller
-> the controller calls a model if database data is needed
-> the controller loads a view
-> the view displays HTML to the user
```

The main roles are:

- Student: consults voyages, registers, uploads documents.
- Responsible teacher: creates voyages, manages inscriptions, checks documents.
- Admin: validates voyages, manages users, sees stats and documents.
- Finance role: prepared in the database for future evolution.

## 2. Main Project Folders

### Root folder

Path:

```text
C:\Users\Mega pc\Desktop\js_php project
```

This contains the whole project.

Important files in the root:

- `README.md`: installation and project usage.
- `RAPPORT_PROJET.md`: report summary for presentation.
- `DEMO_SCENARIO.md`: step-by-step demo script.
- `CHECKLIST_FINAL.md`: final project checklist.
- `To-Study.md`: this study explanation file.
- `js_php_projet_cachier_de_charge.pdf`: original project requirements.
- `.gitignore`: tells Git which files to ignore.

### app/

This is the main PHP application folder.

It contains:

- `config/`
- `core/`
- `controllers/`
- `models/`
- `views/`

### app/config/

Contains configuration files.

Files:

- `config.php`
- `database.php`

This folder defines database access, project paths, session startup, and autoloading.

### app/core/

Contains shared base code used by the whole project.

Files:

- `Auth.php`
- `Controller.php`
- `Model.php`
- `helpers.php`

These files avoid repeating common code everywhere.

### app/controllers/

Contains the controllers.

Controllers receive requests and execute actions.

Files:

- `AuthController.php`
- `HomeController.php`
- `VoyageController.php`
- `InscriptionController.php`
- `DocumentController.php`
- `AdminController.php`

### app/models/

Contains database models.

Models use PDO to read and write data in MySQL/MariaDB.

Files:

- `User.php`
- `Voyage.php`
- `Inscription.php`
- `Document.php`

### app/views/

Contains the HTML/PHP pages.

The files are `.php`, not `.html`, because the pages display dynamic data from the database.

Subfolders:

- `layouts/`: shared layout.
- `auth/`: login/register pages.
- `voyages/`: voyage list and details.
- `inscriptions/`: student inscription history.
- `documents/`: student document list.
- `responsable/`: responsible teacher pages.
- `admin/`: admin pages.
- `errors/`: error pages.

### assets/

Contains front-end files.

Subfolders:

- `css/`: styles.
- `js/`: JavaScript.
- `img/`: images, currently empty.

Important files:

- `assets/css/app.css`
- `assets/js/app.js`

### database/

Contains SQL files.

Files:

- `schema.sql`: creates the database and tables.
- `seed.sql`: inserts demo users and sample data.

### public/

Contains the public entry point.

Files:

- `index.php`
- `.htaccess`

The browser starts from `public/index.php`.

### uploads/

Contains uploaded files.

Subfolder:

- `uploads/documents/`

Important file:

- `uploads/documents/.htaccess`

This file prevents direct access to uploaded documents through Apache.

## 3. Important Files And Their Roles

## public/index.php

This is the entry point of the application.

It does three main things:

1. Loads configuration.
2. Defines the routes.
3. Calls the correct controller method.

Example route:

```php
'login' => [AuthController::class, 'login'],
```

This means:

```text
If the URL has route=login,
then PHP creates AuthController
and calls login().
```

Another example:

```php
'admin/dashboard' => [AdminController::class, 'dashboard'],
```

This means:

```text
route=admin/dashboard
calls AdminController->dashboard()
```

Important ideas:

- `current_route()` reads the route from the URL.
- If a route does not exist, the app shows a 404 page.
- The `try/catch` block catches database/server errors and shows a 500 page.

How to explain it:

> `public/index.php` is the front controller. It receives all requests and sends them to the correct controller.

## app/config/config.php

This file contains global configuration.

Important constants:

```php
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'app');
define('VIEW_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'views');
```

These constants help the application find folders.

Database constants:

```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'gestion_voyages_etudes');
define('DB_USER', 'root');
define('DB_PASS', '');
```

These are used to connect to MySQL/MariaDB.

Session:

```php
session_start();
```

Sessions are needed to keep the user logged in.

Autoload:

```php
spl_autoload_register(...)
```

This automatically loads classes from:

- `app/core`
- `app/models`
- `app/controllers`

So when we write:

```php
new User()
```

PHP can automatically load:

```text
app/models/User.php
```

## app/config/database.php

This file contains the `Database` class.

Main function:

```php
public static function connection(): PDO
```

This function creates the database connection.

It uses PDO:

```php
self::$connection = new PDO($dsn, DB_USER, DB_PASS, [...]);
```

Important PDO options:

- `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`: database errors become exceptions.
- `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC`: results are associative arrays.
- `PDO::ATTR_EMULATE_PREPARES => false`: uses real prepared statements.

How to explain it:

> `database.php` creates one secure PDO connection and reuses it for all models.

## app/core/helpers.php

This file contains small helper functions used everywhere.

### e()

```php
function e(?string $value): string
```

Escapes output before displaying it in HTML.

Example:

```php
<?= e($voyage['titre']) ?>
```

This helps prevent XSS attacks.

### url()

Creates a URL for a route.

Example:

```php
url('voyage/show', ['id' => 1])
```

Creates:

```text
/public/index.php?route=voyage/show&id=1
```

### asset()

Creates a path for CSS/JS files.

Example:

```php
asset('assets/css/app.css')
```

### redirect()

Redirects the user to another page.

Example:

```php
redirect('login');
```

### flash()

Stores a temporary message in the session.

Example:

```php
flash('success', 'Voyage cree.');
```

### get_flash_messages()

Displays and removes flash messages.

### csrf_token()

Creates a CSRF token for form security.

### csrf_field()

Creates this hidden input:

```html
<input type="hidden" name="csrf_token" value="...">
```

### verify_csrf()

Checks if the submitted CSRF token is valid.

Used in POST actions.

### status_label()

Converts database status values into readable labels.

Example:

```text
en_attente -> En attente
valide -> Valide
refuse -> Refuse
archive -> Archive
```

### excerpt()

Shortens long descriptions.

### current_route()

Reads the current route from the URL.

## app/core/Auth.php

This class manages authentication and role protection.

### user()

Returns the current logged-in user from the session.

### id()

Returns the current user ID.

### check()

Returns true if a user is logged in.

### role()

Returns the current user role.

Possible roles:

- `etudiant`
- `responsable`
- `admin`
- `financier`

### login()

Stores the user in the session.

Important:

```php
session_regenerate_id(true);
```

This improves login security.

### logout()

Removes the user from the session.

### requireLogin()

Blocks a page if the user is not logged in.

### requireRole()

Blocks a page if the user does not have the required role.

Example:

```php
Auth::requireRole('admin');
```

Means only admins can access that page.

How to explain it:

> `Auth.php` controls login, logout, current user information and page permissions.

## app/core/Controller.php

This is the base class for all controllers.

### view()

Loads a view file inside the main layout.

Example:

```php
$this->view('auth/login', [
    'title' => 'Connexion'
]);
```

This loads:

```text
app/views/auth/login.php
```

Important line:

```php
extract($data, EXTR_SKIP);
```

This converts array keys to variables.

Example:

```php
['title' => 'Connexion']
```

becomes:

```php
$title
```

### validateRequired()

Checks if required form fields are empty.

## app/core/Model.php

This is the base class for all models.

It gives every model access to the database:

```php
$this->db = Database::connection();
```

So in a model we can use:

```php
$this->db->prepare(...)
```

## 4. Controllers

Controllers contain the logic of user actions.

## AuthController.php

Handles login, registration and logout.

### login()

Displays the login page.

### authenticate()

Handles the login form.

Steps:

1. Verifies CSRF token.
2. Reads email and password.
3. Checks required fields.
4. Finds the user by email.
5. Checks the password with `password_verify()`.
6. Checks if account status is active.
7. Stores the user in session with `Auth::login()`.
8. Redirects to the home route.

Important line:

```php
password_verify($password, $user['mot_de_passe'])
```

### register()

Displays the student registration page.

### storeRegister()

Creates a new student account.

Steps:

1. Verifies CSRF token.
2. Validates name, email and password.
3. Checks email format.
4. Checks if email already exists.
5. Creates the user with role `etudiant`.

### logout()

Logs the user out.

## HomeController.php

Contains one main function:

### index()

Redirects users based on role:

```text
admin -> admin dashboard
responsable -> responsible voyages page
others -> voyages list
```

## VoyageController.php

Handles voyage pages and actions.

### index()

Displays validated voyages.

Also supports search by title or destination.

### show()

Displays details of one voyage.

If the user is a student, it checks whether the student is already registered.

### mine()

Shows voyages created by the responsible teacher.

Protected by:

```php
Auth::requireRole('responsable');
```

### create()

Displays the create voyage form.

### store()

Saves a new voyage.

Important:

```php
$data['id_responsable'] = Auth::id();
```

This links the voyage to the current responsible user.

The voyage starts as `en_attente`.

### edit()

Displays the edit form for a responsible user's own voyage.

### update()

Updates a voyage if it belongs to the current responsible user.

### inscriptions()

Shows students registered for one voyage.

Also shows documents uploaded for that voyage.

### archive()

Lets the responsible archive their own voyage.

### validatedVoyageInput()

Private function that validates voyage form data.

It checks:

- title
- destination
- description
- departure date
- return date
- budget
- number of places

It also checks:

- return date is after departure date
- budget is not negative
- number of places is positive

## InscriptionController.php

Handles student inscriptions.

### store()

Creates a student inscription.

Checks:

1. User role is student.
2. CSRF token is valid.
3. Voyage exists.
4. Voyage status is `valide`.
5. Student is not already registered.
6. Voyage is not full.

If voyage is full, inscription is created with status:

```text
refuse
```

Otherwise, status is:

```text
en_attente
```

### mine()

Shows current student's inscriptions.

Also loads documents grouped by voyage.

### updateStatus()

Responsible validates or refuses an inscription.

Allowed statuses:

```php
['valide', 'refuse']
```

## AdminController.php

Handles administrator pages.

### dashboard()

Shows simple statistics:

- total voyages
- pending voyages
- validated voyages
- archived voyages
- users by role
- inscriptions by voyage

### users()

Displays users and the create-user form.

### storeUser()

Admin creates a user.

Validates:

- name
- email
- password
- role

### updateUser()

Admin changes user role and status.

Important protection:

```php
if ($id === Auth::id() && $statut === 'inactif')
```

This prevents the admin from disabling their own account.

### voyages()

Shows all voyages for admin validation.

### validateVoyage()

Sets voyage status to:

```text
valide
```

### refuseVoyage()

Sets voyage status to:

```text
refuse
```

### archiveVoyage()

Sets voyage status to:

```text
archive
```

### setVoyageStatus()

Private helper used by validate/refuse/archive functions.

## DocumentController.php

Handles document upload and download.

### Constants

```php
private const MAX_SIZE = 5242880;
private const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png'];
```

Meaning:

- max file size is 5 MB
- accepted formats are PDF and images

### mine()

Shows documents uploaded by the current student.

### adminIndex()

Shows all documents to admin.

### upload()

Handles document upload.

Steps:

1. Requires student role.
2. Verifies CSRF token.
3. Checks student is registered to the voyage.
4. Checks document type is filled.
5. Checks a file was selected.
6. Checks upload errors.
7. Checks file size.
8. Checks file extension.
9. Creates upload folder if needed.
10. Generates a safe filename.
11. Moves the uploaded file.
12. Saves document information in database.

Important function:

```php
move_uploaded_file(...)
```

### download()

Downloads a document after checking access rights.

### canAccess()

Private function that controls document access:

```text
admin -> all documents
responsible -> documents for their voyages
student -> their own documents
```

## 5. Models

Models contain SQL queries.

## User.php

Handles users.

### findByEmail()

Finds a user by email.

Used during login.

### find()

Finds a user by ID.

### create()

Creates a user.

Important:

```php
password_hash($data['mot_de_passe'], PASSWORD_DEFAULT)
```

This stores a hashed password, not a plain password.

### all()

Returns all users for the admin page.

### updateRoleAndStatus()

Updates a user's role and status.

### countByRole()

Counts users by role for dashboard.

## Voyage.php

Handles voyages.

### validated()

Returns only voyages with status `valide`.

Can filter by search text.

### find()

Finds one voyage by ID.

### byResponsible()

Returns voyages created by one responsible user.

### pending()

Returns pending voyages.

### allForAdmin()

Returns all voyages for admin.

### create()

Creates a voyage.

### update()

Updates a voyage if it belongs to the responsible user.

### updateStatus()

Changes voyage status.

Used by admin.

### updateStatusForResponsible()

Changes status only if the voyage belongs to the responsible user.

### countActiveInscriptions()

Counts active inscriptions for one voyage.

### stats()

Returns voyage statistics for dashboard.

### baseSelect()

Private function containing a shared SQL query.

It calculates:

- responsible name
- number of inscriptions
- remaining places

This is one of the most important SQL functions in the project.

## Inscription.php

Handles inscriptions.

### exists()

Checks if a student is already registered for a voyage.

### create()

Creates an inscription.

### forStudent()

Returns inscriptions for one student.

### forVoyage()

Returns inscriptions for one voyage.

### updateStatusForResponsible()

Responsible validates or refuses an inscription only if the voyage belongs to them.

This is important for security.

### statsByVoyage()

Counts inscriptions by voyage for dashboard.

## Document.php

Handles document records.

### create()

Saves document information in database.

### forStudent()

Returns documents uploaded by one student.

### forVoyage()

Returns documents for one voyage.

### all()

Returns all documents for admin.

### findWithContext()

Finds a document and also gets voyage responsible ID.

Used to check access rights.

### groupByVoyageForStudent()

Groups student documents by voyage.

Used on the student inscriptions page.

## 6. Views

Views display HTML.

## app/views/layouts/main.php

This is the main layout.

It contains:

- HTML structure
- CSS link
- navigation menu
- flash messages
- footer
- JavaScript link

Important line:

```php
<?php require $viewFile; ?>
```

This inserts the current page content inside the layout.

The navigation changes depending on role:

```php
Auth::role() === 'admin'
```

## app/views/auth/login.php

Displays the login form.

Important:

```php
<?= csrf_field() ?>
```

This adds CSRF protection.

## app/views/auth/register.php

Displays the student registration form.

## app/views/voyages/index.php

Displays validated voyages as cards.

Also contains the search form.

## app/views/voyages/show.php

Displays voyage details.

If user is a student, it shows the inscription button.

## app/views/inscriptions/mine.php

Displays student inscriptions.

Also allows document upload.

## app/views/documents/mine.php

Displays documents uploaded by the student.

## app/views/responsable/voyages.php

Displays responsible user's voyages.

Actions:

- edit
- see inscriptions
- archive

## app/views/responsable/form.php

Form for creating or editing a voyage.

## app/views/responsable/inscriptions.php

Displays:

- registered students
- validate/refuse buttons
- uploaded documents

## app/views/admin/dashboard.php

Displays simple statistics.

## app/views/admin/voyages.php

Admin validates/refuses/archives voyages.

## app/views/admin/users.php

Admin creates users and changes role/status.

## app/views/admin/documents.php

Admin views uploaded documents.

## app/views/errors/

Contains error pages:

- `403.php`: access denied
- `404.php`: page not found
- `500.php`: server/database error

## 7. Assets

## assets/css/app.css

Contains all styling.

Important CSS classes:

- `.site-header`: top navigation.
- `.page`: main page width.
- `.panel`: white box/panel.
- `.button`: buttons.
- `.badge`: status labels.
- `.table-wrap`: responsive tables.
- `.cards-grid`: voyage cards.
- `.alert`: flash messages.
- `.form`: forms.

## assets/js/app.js

Small JavaScript file for mobile menu.

It finds:

```js
const toggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');
```

Then opens/closes menu:

```js
menu.classList.toggle('open');
```

## 8. Database

## database/schema.sql

Creates database and tables.

Main database:

```sql
gestion_voyages_etudes
```

### users table

Stores users.

Important columns:

- `id_user`
- `nom`
- `prenom`
- `email`
- `mot_de_passe`
- `role`
- `statut`
- `date_creation`

Important:

```sql
email VARCHAR(190) NOT NULL UNIQUE
```

Emails must be unique.

### voyages table

Stores voyages.

Important columns:

- `id_voyage`
- `titre`
- `destination`
- `description`
- `date_depart`
- `date_retour`
- `budget`
- `nb_places`
- `statut`
- `id_responsable`

Statuses:

- `en_attente`
- `valide`
- `refuse`
- `archive`

### inscriptions table

Connects students to voyages.

Important columns:

- `id_inscription`
- `id_user`
- `id_voyage`
- `date_inscription`
- `statut`

Important constraint:

```sql
UNIQUE KEY uniq_inscription_user_voyage (id_user, id_voyage)
```

This prevents duplicate inscriptions.

### documents table

Stores uploaded document information.

Important columns:

- `id_document`
- `id_user`
- `id_voyage`
- `type_document`
- `chemin_fichier`
- `date_upload`

### paiements table

Prepared for future payment module.

Not used in the interface in this version.

## database/seed.sql

Inserts demo data.

Demo accounts:

```text
admin@example.com / password
responsable@example.com / password
etudiant@example.com / password
```

Also inserts one sample voyage.

## 9. Uploads

## uploads/documents/

Stores uploaded student documents.

## uploads/documents/.htaccess

Contains:

```apache
Require all denied
```

This prevents direct file access through Apache.

Documents should be downloaded through:

```text
route=document/download
```

That way PHP checks permissions first.

## 10. Main Workflows

## Student registration workflow

```text
Student opens a validated voyage
-> clicks S'inscrire
-> InscriptionController::store()
-> checks role, CSRF, voyage status, duplicate inscription, remaining places
-> Inscription model creates inscription
-> student sees inscription in Mes inscriptions
```

## Voyage creation workflow

```text
Responsible logs in
-> opens Espace responsable
-> creates a voyage
-> VoyageController::store()
-> Voyage model inserts voyage with status en_attente
-> admin later validates it
```

## Admin validation workflow

```text
Admin logs in
-> opens Validation voyages
-> clicks Valider
-> AdminController::validateVoyage()
-> Voyage status becomes valide
-> students can now register
```

## Document upload workflow

```text
Student has an inscription
-> opens Mes inscriptions
-> chooses document type and file
-> DocumentController::upload()
-> checks role, CSRF, file type, file size
-> saves file in uploads/documents
-> saves path in documents table
```

## Responsible inscription validation workflow

```text
Responsible opens voyage inscriptions
-> sees students and documents
-> clicks Valider or Refuser
-> InscriptionController::updateStatus()
-> Inscription model updates the status
```

## 11. Security Points To Explain

### Password hashing

Passwords are stored using:

```php
password_hash()
```

And checked using:

```php
password_verify()
```

### SQL injection protection

The project uses PDO prepared statements:

```php
$stmt = $this->db->prepare(...);
$stmt->execute([...]);
```

### Role protection

Example:

```php
Auth::requireRole('admin');
```

### CSRF protection

Forms contain:

```php
<?= csrf_field() ?>
```

Controllers check:

```php
verify_csrf();
```

### XSS protection

Views display data using:

```php
<?= e($value) ?>
```

### Upload protection

The project checks:

- file extension
- file size
- user role
- inscription existence
- document access rights

## 12. What To Study First

If you have limited time, study these files first:

1. `public/index.php`
2. `app/config/config.php`
3. `app/config/database.php`
4. `app/core/Auth.php`
5. `app/core/helpers.php`
6. `app/controllers/AuthController.php`
7. `app/controllers/VoyageController.php`
8. `app/controllers/InscriptionController.php`
9. `app/models/Voyage.php`
10. `app/models/Inscription.php`
11. `database/schema.sql`
12. `app/views/layouts/main.php`

## 13. Simple Explanation For The Teacher

You can say:

> This project is a PHP/MySQL application for managing study trips. It uses a simple MVC architecture. The entry point is `public/index.php`, which routes each request to a controller. Controllers handle user actions, models communicate with the database using PDO prepared statements, and views display HTML pages. The project includes authentication, roles, voyage validation, student inscriptions, document upload and a simple admin dashboard.

## 14. Where The Project Stops

The project intentionally stops at a simple first-year level.

Not included:

- online payment
- internal messaging
- mobile application
- complex dashboard
- REST API
- Laravel or another framework

These can be mentioned as future improvements.
