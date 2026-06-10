<?php
// 1. Include your working database connection file
include('Connectivity.php'); 

// 2. Fetch all student records
$query = "SELECT student_id, name, surname, clg_name FROM students";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Student QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .student-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            border: 1px solid #e0e0e0;
        }
        .student-card h3 {
            margin: 10px 0 5px 0;
            font-size: 1.1em;
            color: #222;
        }
        .student-card p {
            margin: 3px 0;
            font-size: 0.85em;
            color: #666;
        }
        .qr-img {
            margin: 15px 0;
            width: 150px;
            height: 150px;
        }
        .download-btn {
            display: inline-block;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            font-size: 0.8em;
            border-radius: 5px;
            margin-top: 5px;
        }
        .download-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>All Student QR Codes</h1>

    <div class="grid-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            // Loop through all 10 students
            while($row = mysqli_fetch_assoc($result)) {
                
                // Format the text that will be embedded inside the QR code
                $qrText = "ID: " . $row['student_id'] . "\n" .
                          "Name: " . $row['name'] . " " . $row['surname'] . "\n" .
                          "College: " . $row['clg_name'];
                
                // Safe conversion for URL parameter
                $encodedText = urlencode($qrText);
                
                // Generate QR Code dynamic URL via open API
                $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . $encodedText;
                ?>
                
                <div class="student-card">
                    <p style="font-weight: bold; color: #007bff;"><?php echo $row['student_id']; ?></p>
                    <img class="qr-img" src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
                    <h3><?php echo $row['name'] . " " . $row['surname']; ?></h3>
                    <p><?php echo $row['clg_name']; ?></p>
                    <a href="<?php echo $qrCodeUrl; ?>" target="_blank" download="<?php echo $row['student_id']; ?>_qr.png" class="download-btn">Download QR</a>
                </div>

                <?php
            }
        } else {
            echo "<p>No student records found in the database. Please make sure your table has data.</p>";
        }
        // Close connection
        mysqli_close($conn);
        ?>
    </div>

</body>
</html>