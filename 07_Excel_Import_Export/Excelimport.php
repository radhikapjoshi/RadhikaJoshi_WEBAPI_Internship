<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    
   
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if ($fileError === 0) {
        if ($fileExt === 'csv') {
            
          
            if (($handle = fopen($fileTmpName, 'r')) !== FALSE) {
                
                $message = "<p style='color: green;'><strong>Success!</strong> File read successfully.</p>";
                echo "<h3>Previewing Imported Data:</h3>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                
               
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td>" . htmlspecialchars($cell ?? '') . "</td>";
                    }
                    echo "</tr>";
                }
                
                echo "</table><br><hr>";
                fclose($handle); // Always close the file handler
                
            } else {
                $message = "<p style='color: red;'>Error opening the temporary file.</p>";
            }
        } else {
            $message = "<p style='color: red;'>Invalid file type. Please save your Excel file as a .csv file first.</p>";
        }
    } else {
        $message = "<p style='color: red;'>There was an error uploading your file.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSV Import (No Libraries)</title>
</head>
<body>

    <h2>Upload and Import CSV File</h2>
    <?php echo $message; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="csv_file">Select CSV File:</label>
        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
        <br><br>
        <button type="submit">Import Data</button>
    </form>

</body>
</html>