
# Te Hauora o Te Hinengaro - Mental Wellness Tracker

Te Hauora o Te Hinengaro is a mental wellness tracker website designed to help users monitor their emotional well-being, set goals, and receive self-care suggestions. The platform emphasizes partnership, participation, and protection in accordance with the principles of Te Tiriti o Waitangi and provides culturally appropriate content.

## Features
- **User Authentication**: Secure user registration and login functionality.
- **Mood Tracking**: Allows users to log their daily moods, visualize trends with charts, and gain insights over time.
- **Goal Setting**: Users can set personal mental wellness goals, mark goals as complete, and view their progress.
- **Self-Care Suggestions**: Provides dynamic and personalized self-care tips based on user moods and goals.
- **Contact and Support**: Lists New Zealand’s key mental health support contacts and allows users to reach out via a contact form.
- **Responsive Design**: Built using Bootstrap to provide a seamless experience on desktop and mobile devices.

## Technologies Used
- **PHP**: Backend language used to handle form submissions, database connections, and user sessions.
- **MySQL**: Database to store user information, mood entries, goals, and self-care suggestions.
- **Bootstrap 5**: Frontend framework for responsive design and consistent UI components.
- **Docker**: Containerization for easy deployment, with services for web and database containers.
- **Chart.js**: Used to display mood trends graphically in the mood-tracking section.
- **msmtp**: Used for sending emails through the contact form.

## Installation

### Clone the Repository:

```bash
git clone https://github.com/mebss/MSE-800-Professional-Engineering-Group-Project-.git
cd mental-wellness-tracker
```

### Set up Docker:
Ensure you have Docker installed. Use docker-compose to build and start the containers:

```bash
docker-compose up --build
```

### Configure SMTP for Email (Optional for Contact Form):
Edit the `msmtprc` file for setting up email services.
The file should contain the SMTP details of the mail server you're using (e.g., Outlook).

### Access the Website:
Once Docker is running, access the application in your browser:

```bash
http://localhost:8080
```

## Database Initialization

The database `mental_wellness_tracker` will be automatically set up with the following tables:
- `users`: Stores user credentials.
- `moods`: Logs daily mood entries.
- `goals`: Stores user-set goals and tracks their completion status.

The `db/init.sql` file contains the SQL schema used to create the required tables.

## Database Connection Configuration

To successfully connect to the MySQL database, ensure that you update the database connection details in the `db_connection.php` file.

### db_connection.php
The `db_connection.php` file is used to establish a connection between the PHP application and the MySQL database. Here is the structure of the file:

```php
<?php
$servername = "db";  // "db" is used as the service name in Docker
$username = "your_mysql_username";  // Your MySQL username
$password = "your_mysql_password";  // Your MySQL root password from the docker-compose file
$dbname = "mental_wellness_tracker";  // The name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### Update Credentials
- **Server Name**: By default, Docker will use the service name `db` as the hostname. If you're not using Docker, change it to `localhost` or the IP of your database server.
- **Username and Password**: If you're using your own database server, replace:

```php
$username = "your_mysql_username";
$password = "your_mysql_password";
```

with your own MySQL username and password. For example:

```php
$username = "your_mysql_username";
$password = "your_mysql_password";
```

- **Database Name**: Ensure the database name matches the one created by the SQL script (`mental_wellness_tracker` in this case). If you choose a different name, update the `$dbname` variable:

```php
$dbname = "your_database_name";
```

### Connection Test
Once the credentials are updated, the application should be able to connect to your MySQL database. If there are any connection issues, check the following:
- Make sure the MySQL server is running.
- Verify that the correct credentials are being used.
- Ensure the correct database name is set.

## Usage

1. **User Registration and Login**
   - New users can register by providing a username, email, and password.
   - Users must log in to access mood tracking, goal setting, and self-care features.

2. **Mood Tracking**
   - Log your daily mood and view trends over time through a line chart.
   - Moods include: Happy, Sad, Stressed, Excited, Calm, etc.
   - Recent mood entries are displayed on the homepage.

3. **Goal Setting**
   - Set personal goals to improve your mental wellness.
   - Mark goals as complete and track ongoing and completed goals.

4. **Self-Care Suggestions**
   - Get personalized self-care tips and resources based on your mood and goals.
   - Additional external resources for mental wellness are provided.

5. **Contact Us**
   - View a list of key mental health services in New Zealand.
   - Send a message using the contact form, which will be emailed to the admin (via the configured `msmtp` settings).

## Contributing
Contributions are welcome! If you have any suggestions or improvements, feel free to create a pull request or open an issue.

## License
This project is licensed under the MIT License - see the LICENSE file for details.
