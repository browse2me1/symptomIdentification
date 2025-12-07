<?php
include('menubar.php');
include('headers.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 30px;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
        }

        .label {
            font-weight: bold;
        }
        footer {
    text-align: center;
    margin-top: 40px;
    padding: 20px;
    height: 150px;
   border-radius: 5px;
    background-color: #2c3e50;
    color: #7f8c8d;
}
    </style>
</head>
<body>

<div class="container">
    <h2>📞 Contact Us</h2>

    <p><span class="label">Email:</span> support@healthchecker.org</p>
    <p><span class="label">Phone:</span> +251 943915972</p>
    <p><span class="label">Address:</span> Gondar, Ethiopia</p>
    <p><span class="label">Hours:</span> Monday - Friday, 9:00 AM – 5:00 PM</p>
</div>
<?php
include('footer.php');
?>
</body>
</html>
