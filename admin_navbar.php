<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .admin-navbar {
      background-color: #343a40;
      color: white;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      align-items: center;
      padding: 10px 20px;
    }

    .admin-navbar .menu {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .admin-navbar a {
      color: white;
      text-decoration: none;
      padding: 10px;
      transition: background 0.3s;
    }

    .admin-navbar a:hover {
      background-color: #495057;
      border-radius: 4px;
    }

    .admin-navbar .user-info {
      font-size: 0.9rem;
    }

    @media (max-width: 600px) {
      .admin-navbar {
        flex-direction: column;
        align-items: flex-start;
      }
      .admin-navbar .menu {
        flex-direction: column;
        width: 100%;
      }
      .admin-navbar a {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="admin-navbar">
  <div class="menu">
    <a href="manage_diseases.php">Diseases</a>
    <a href="manage_symptoms.php">Symptoms</a>
    <a href="manage_mapping.php">Mapping</a>
    <a href="index.php">Back to Home</a>
    <a href="logout.php">Logout</a>
    <a href="admin_sign up.php">Sign up</a>
  </div>
  <div class="user-info">
    Logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
  </div>
</div>
