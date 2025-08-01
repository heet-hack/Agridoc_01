<?php
// submit.php (updated with secure insert and .env-style config)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "agridoc_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST values
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cropName = $_POST['cropName'] ?? '';
    $soilType = $_POST['soilType'] ?? '';
    $soilColor = $_POST['soilColor'] ?? '';
    $location = $_POST['location'] ?? '';
    $climate = $_POST['climate'] ?? '';
    $fertilizersUsed = $_POST['fertilizersUsed'] ?? '';
    $visiblesymptom = $_POST['visiblesymptom'] ?? '';

    // if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    //     $imageTmpPath = $_FILES['image']['tmp_name'];
    //     $imageData = file_get_contents($imageTmpPath);
    // } else {
    //     die("Image upload failed or not provided.");
    // }

    // Now continue with database insertion...
}


// Prepared statement insert
$stmt = $conn->prepare("INSERT INTO crops (cropName, soilType, soilColor, location, climate, fertilizersUsed, visiblesymptom, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $cropName, $soilType, $soilColor, $location, $climate, $fertilizersUsed, $visiblesymptom, $imageData);
$stmt->execute();
$last_insert_id = $stmt->insert_id;
$stmt->close();

// GPT API call
$url = "https://api.openai.com/v1/chat/completions";
$api_key = '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';

$userMessage = "I have a $cropName plant. Soil type is $soilType and soil color is $soilColor. "
             . "It is located in $location. The current weather is $climate. "
             . "I am using $fertilizersUsed as fertilizer. I can see $visiblesymptom. "
             . "Please give me a short accurate and well planned suggestion (2-3 main imp points) to grow my crop well and tell if the plant is already in best condition.";

$data = [
    "model" => "gpt-4",
    "messages" => [
        ["role" => "user", "content" => $userMessage]
    ]
];

$jsonData = json_encode($data);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = json_decode(curl_exec($ch));
$response = isset($response->choices[0]->message->content) ? $response->choices[0]->message->content : "";

$stmt = $conn->prepare("UPDATE crops SET api_response = ? WHERE id = ?");
$stmt->bind_param("si", $response, $last_insert_id);
$stmt->execute();

$conn->close();
header("Location: result.php?id=$last_insert_id");
exit();

// header("Location: result.php?id=$last_insert_id");
// exit();


?>