<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Symptom-Based Disease ID System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
  <style>
    .header-bar {
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      border-bottom: 2px solid #007bff;
      flex-wrap: wrap;
    }

    .header-bar img {
      height: 60px;
    }

    .header-bar .system-title {
      font-size: 1.4rem;
      font-weight: bold;
      color: #2c3e50;
      text-align: right;
      flex: 1;
      padding-left: 20px;
    }

    @media (max-width: 600px) {
      .header-bar {
        flex-direction: column;
        text-align: center;
      }

      .header-bar .system-title {
        padding-left: 0;
        font-size: 1.2rem;
      }

      .header-bar img {
        height: 50px;
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

<div class="header-bar">
  <img src="logo.png" alt="University Logo">
  <div class="system-title">Symptom-Based Disease Identification System</div>
</div>
