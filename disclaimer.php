<?php
session_start();
// If user already accepted, redirect to input page
if (isset($_SESSION['disclaimer_accepted'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['disclaimer_accepted'] = true;
    header("Location: input_symptoms.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Disclaimer</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include 'headers.php'; ?>
    <style>
        body {
            background-color:rgb(186, 219, 241);
            padding: 40px;
            text-align: center;
        }
        @media (max-width: 600px) {
      .header-bar{
      margin-top:0;
      }}

        .disclaimer-box {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            margin-top: 2em;
            border-radius: 10px;
        }

        button {
            margin-top: 25px;
            background-color: #28a745;
            color: white;
            padding: 10px 25px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
        .succes {
            background: #aaebda;
            color: #191a19;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="disclaimer-box">
    <h2>⚠️ Medical Disclaimer</h2>
    <p>
        This system is provided for informational and health awareness purposes only.
        It is not a substitute for professional medical advice, diagnosis, or treatment.
        Always seek advice from a qualified healthcare provider with any questions you may have.
    </p>

    <form method="post">
        <button type="submit">I Understand → Continue</button>
    </form>
</div>

</body>
</html>
