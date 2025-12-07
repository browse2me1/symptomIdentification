<?php
include 'admin_navbar.php';

 

// Redirect if not logged in or not admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom checker|Manage Page</title>
    <style>
       body { 
             background-color: #E3F2FD;
              text-align:center;
            
    }
        h2 {
            color: #333;
        }
        .manage-links a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .manage-links a:hover {
            background-color: #0056b3;
        }
        header {
            margin-top:15px;
             width: 100%;
             text-align: center;
             margin-bottom: 30px;
             background-color: #2c3e50;
             color: white;
             border-top-left-radius: 5px;
   
    
}

    </style>
</head>
<?php
     include'admin_header.php';
     ?>
<body>

<h2>Admin - Manage Data</h2>

<div class="manage-links">
    <a href="manage_diseases.php">Manage Diseases</a>
    <a href="manage_symptoms.php">Manage Symptoms</a>
    <a href="manage_mapping.php">Manage Mappings</a>
</div>

<a href="logout.php" style="margin-top: 30px; display: inline-block;">Logout</a>

</body>
</html>
