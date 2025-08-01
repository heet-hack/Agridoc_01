<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "agridoc_db";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$api_response = mysqli_fetch_assoc(mysqli_query($conn, "SELECT api_response FROM crops WHERE id='$id'"));

if (is_null($api_response)) {
    echo "❌ Something went wrong or no result found."; exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>🌾 Fasal X – AI Suggestion</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(to right, #e8f5e9, #c8e6c9);
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 40px 20px;
    }

    .card {
      background: #ffffff;
      max-width: 900px;
      width: 100%;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
      animation: slideFade 1s ease-out;
    }

    h1 {
      font-size: 2.5rem;
      color: #2e7d32;
      margin-bottom: 25px;
      text-align: center;
      position: relative;
    }

    h1::after {
      content: "";
      display: block;
      width: 60px;
      height: 4px;
      background: #66bb6a;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    .response-box {
      background: #f1f8e9;
      padding: 30px;
      border-radius: 12px;
      border-left: 8px solid #81c784;
      font-size: 1.15rem;
      color: #333;
      line-height: 1.8;
      white-space: pre-line;
      transition: all 0.3s ease;
    }

    .response-box:hover {
      background: #e6f5d0;
      box-shadow: 0 0 20px rgba(129, 199, 132, 0.2);
    }

    @keyframes slideFade {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .footer {
      text-align: center;
      margin-top: 30px;
      font-size: 0.95rem;
      color: #777;
    }

    .btn {
      margin-top: 30px;
      display: inline-block;
      padding: 12px 25px;
      background: #66bb6a;
      color: white;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background: #4caf50;
    }

  </style>
</head>
<body>
  <div class="card">
    <h1>🌿 Fasal X – Expert AI Suggestion</h1>
    <div class="response-box">
      <?= nl2br(htmlspecialchars($api_response['api_response'])) ?>
    </div>
    <div class="footer">
      ✅ This recommendation is based on your submitted crop details.<br>
      <a href="index.php" class="btn">🔙 Go Back & Submit New</a>
    </div>
  </div>
</body>
</html>
