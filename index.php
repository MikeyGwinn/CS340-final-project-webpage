<?php
// Database connection configuration
$host = 'localhost';
$dbname = 'CS340-term-project-1';
$username = 'phpmyadmin';
$password = 'CS340termproject';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'add_student':
            $stmt = $pdo->prepare("INSERT INTO Students (first_name, last_name, email, major, graduation_year) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['major'], $_POST['graduation_year']]);
            $message = "Student added successfully!";
            break;
            
        case 'add_company':
            $stmt = $pdo->prepare("INSERT INTO Companies (name, industry, location, description, contact_email) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['name'], $_POST['industry'], $_POST['location'], $_POST['description'], $_POST['contact_email']]);
            $message = "Company added successfully!";
            break;
            
        case 'add_internship':
            $stmt = $pdo->prepare("INSERT INTO Internships (company_id, title, description, location, application_deadline, wage, posting_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['company_id'], $_POST['title'], $_POST['description'], $_POST['location'], $_POST['application_deadline'], $_POST['wage'], $_POST['posting_date']]);
            $message = "Internship added successfully!";
            break;
            
        case 'add_application':
            $stmt = $pdo->prepare("INSERT INTO Applications (internship_id, student_id, application_date, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['internship_id'], $_POST['student_id'], $_POST['application_date'], $_POST['status']]);
            $message = "Application added successfully!";
            break;
    }
}

// Handle deletions
if (isset($_GET['delete'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];
    
    switch($table) {
        case 'students':
            $stmt = $pdo->prepare("DELETE FROM Students WHERE student_id = ?");
            $stmt->execute([$id]);
            $message = "Student deleted successfully!";
            break;
        case 'companies':
            $stmt = $pdo->prepare("DELETE FROM Companies WHERE company_id = ?");
            $stmt->execute([$id]);
            $message = "Company deleted successfully!";
            break;
        case 'internships':
            $stmt = $pdo->prepare("DELETE FROM Internships WHERE internship_id = ?");
            $stmt->execute([$id]);
            $message = "Internship deleted successfully!";
            break;
        case 'applications':
            $stmt = $pdo->prepare("DELETE FROM Applications WHERE application_id = ?");
            $stmt->execute([$id]);
            $message = "Application deleted successfully!";
            break;
    }
}

// Fetch data for display
$students = $pdo->query("SELECT * FROM Students ORDER BY student_id")->fetchAll();
$companies = $pdo->query("SELECT * FROM Companies ORDER BY company_id")->fetchAll();
$internships = $pdo->query("
    SELECT i.*, c.name as company_name 
    FROM Internships i 
    JOIN Companies c ON i.company_id = c.company_id 
    ORDER BY i.internship_id
")->fetchAll();
$applications = $pdo->query("
    SELECT a.*, s.first_name, s.last_name, i.title as internship_title, c.name as company_name
    FROM Applications a
    JOIN Students s ON a.student_id = s.student_id
    JOIN Internships i ON a.internship_id = i.internship_id
    JOIN Companies c ON i.company_id = c.company_id
    ORDER BY a.application_id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: #2c3e50;
            color: white;
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 5px;
        }
        
        .nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .nav button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .nav button:hover {
            background: #2980b9;
        }
        
        .nav button.active {
            background: #e74c3c;
        }
        
        .section {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .section.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .btn {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn:hover {
            background: #229954;
        }
        
        .btn-danger {
            background: #e74c3c;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background: #34495e;
            color: white;
        }
        
        table tr:hover {
            background: #f5f5f5;
        }
        
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Internship Management System</h1>
            <p>Manage students, companies, internships, and applications</p>
        </div>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="nav">
            <button onclick="showSection('students')" class="nav-btn active">Students</button>
            <button onclick="showSection('companies')" class="nav-btn">Companies</button>
            <button onclick="showSection('internships')" class="nav-btn">Internships</button>
            <button onclick="showSection('applications')" class="nav-btn">Applications</button>
        </div>
        
        <!-- Students Section -->
        <div id="students" class="section active">
            <h2>Students Management</h2>
            
            <form method="POST">
                <input type="hidden" name="action" value="add_student">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" name="last_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Major:</label>
                        <input type="text" name="major" required>
                    </div>
                    <div class="form-group">
                        <label>Graduation Year:</label>
                        <input type="number" name="graduation_year" min="2024" max="2030" required>
                    </div>
                </div>
                <button type="submit" class="btn">Add Student</button>
            </form>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Major</th>
                        <th>Graduation Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student['student_id']; ?></td>
                        <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td><?php echo htmlspecialchars($student['major']); ?></td>
                        <td><?php echo $student['graduation_year']; ?></td>
                        <td>
                            <a href="?delete=1&table=students&id=<?php echo $student['student_id']; ?>" 
                               class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Companies Section -->
        <div id="companies" class="section">
            <h2>Companies Management</h2>
            
            <form method="POST">
                <input type="hidden" name="action" value="add_company">
                <div class="form-row">
                    <div class="form-group">
                        <label>Company Name:</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Industry:</label>
                        <input type="text" name="industry" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Location:</label>
                    <input type="text" name="location" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label>Contact Email:</label>
                    <input type="email" name="contact_email" required>
                </div>
                <button type="submit" class="btn">Add Company</button>
            </form>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Industry</th>
                        <th>Location</th>
                        <th>Contact Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($companies as $company): ?>
                    <tr>
                        <td><?php echo $company['company_id']; ?></td>
                        <td><?php echo htmlspecialchars($company['name']); ?></td>
                        <td><?php echo htmlspecialchars($company['industry']); ?></td>
                        <td><?php echo htmlspecialchars($company['location']); ?></td>
                        <td><?php echo htmlspecialchars($company['contact_email']); ?></td>
                        <td>
                            <a href="?delete=1&table=companies&id=<?php echo $company['company_id']; ?>" 
                               class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Internships Section -->
        <div id="internships" class="section">
            <h2>Internships Management</h2>
            
            <form method="POST">
                <input type="hidden" name="action" value="add_internship">
                <div class="form-group">
                    <label>Company:</label>
                    <select name="company_id" required>
                        <option value="">Select Company</option>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?php echo $company['company_id']; ?>">
                                <?php echo htmlspecialchars($company['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Job Title:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Location:</label>
                        <input type="text" name="location" required>
                    </div>
                    <div class="form-group">
                        <label>Monthly Wage ($):</label>
                        <input type="number" name="wage" step="0.01" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Application Deadline:</label>
                        <input type="date" name="application_deadline" required>
                    </div>
                    <div class="form-group">
                        <label>Posting Date:</label>
                        <input type="date" name="posting_date" required>
                    </div>
                </div>
                <button type="submit" class="btn">Add Internship</button>
            </form>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Wage</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($internships as $internship): ?>
                    <tr>
                        <td><?php echo $internship['internship_id']; ?></td>
                        <td><?php echo htmlspecialchars($internship['title']); ?></td>
                        <td><?php echo htmlspecialchars($internship['company_name']); ?></td>
                        <td><?php echo htmlspecialchars($internship['location']); ?></td>
                        <td>$<?php echo number_format($internship['wage']); ?></td>
                        <td><?php echo $internship['application_deadline']; ?></td>
                        <td>
                            <a href="?delete=1&table=internships&id=<?php echo $internship['internship_id']; ?>" 
                               class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Applications Section -->
        <div id="applications" class="section">
            <h2>Applications Management</h2>
            
            <form method="POST">
                <input type="hidden" name="action" value="add_application">
                <div class="form-row">
                    <div class="form-group">
                        <label>Student:</label>
                        <select name="student_id" required>
                            <option value="">Select Student</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?php echo $student['student_id']; ?>">
                                    <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Internship:</label>
                        <select name="internship_id" required>
                            <option value="">Select Internship</option>
                            <?php foreach ($internships as $internship): ?>
                                <option value="<?php echo $internship['internship_id']; ?>">
                                    <?php echo htmlspecialchars($internship['title'] . ' - ' . $internship['company_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Application Date:</label>
                        <input type="date" name="application_date" required>
                    </div>
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="">Select Status</option>
                            <option value="submitted">Submitted</option>
                            <option value="under review">Under Review</option>
                            <option value="interview scheduled">Interview Scheduled</option>
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn">Add Application</button>
            </form>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Internship</th>
                        <th>Company</th>
                        <th>Application Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?php echo $application['application_id']; ?></td>
                        <td><?php echo htmlspecialchars($application['first_name'] . ' ' . $application['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($application['internship_title']); ?></td>
                        <td><?php echo htmlspecialchars($application['company_name']); ?></td>
                        <td><?php echo $application['application_date']; ?></td>
                        <td><?php echo htmlspecialchars($application['status']); ?></td>
                        <td>
                            <a href="?delete=1&table=applications&id=<?php echo $application['application_id']; ?>" 
                               class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all nav buttons
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionName).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
    </script>
</body>
</html>