<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AgriDoc Entry</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="bg-overlay"></div>

  <div class="form-container">
    <form action="loading.php" method="POST" id="cropForm" enctype="multipart/form-data">
      <h2>🌾Fasal X</h2>

      <form action="submit.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="cropName" placeholder="Crop Name (e.g., Wheat)" required />
      <input type="text" name="soilType" placeholder="Soil Type (e.g., Loamy)" required />
      <input type="text" name="soilColor" placeholder="Soil Color (e.g., Red)" required />
      <input type="text" name="location" placeholder="Location (City)" required />
      <input type="text" name="climate" placeholder="Climate (e.g., Sunny)" required />
      <input name="fertilizersUsed" placeholder="Fertilizers Used (e.g., NPK)" required />
      
      <!-- ✅ Replaced invalid input type with proper <textarea> -->
      <textarea name="visiblesymptom" placeholder="Visible Symptoms (e.g., Yellow Leaves)" required></textarea>

      <label for="imageInput">Upload Crop Image:</label>
      <input type="file" name="image" id="imageInput" accept="image/*" required />
      <img id="preview" alt="Image Preview" style="display:none;" />

      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    input.addEventListener('change', () => {
      const file = input.files[0];
      if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
      }
    });
  </script>
</body>
</html>
