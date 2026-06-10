<?php

if (isset($_GET['mode'])) {
   
    $internships = [
        ["studentname" => "Nirali Joshi", "email" => "nirujoshi12@gmail.com", "contact" => "9978796054", "mode" => "online"],
        ["studentname" => "Urvshi Thanki", "email" => "urvshithanki14@gmail.com", "contact" => "9876534201", "mode" => "online"],
        ["studentname" => "Manshi Mehta", "email" => "manshimehta2007@gmail.com", "contact" => "9876543214", "mode" => "online"],
        ["studentname" => "Diya Joshi", "email" => "diyajoshi2008@gmail.com", "contact" => "8876534201", "mode" => "online"],
        ["studentname" => "Radhika Joshi", "email" => "joshiradhika1207@gmail.com", "contact" => "8765432190", "mode" => "onsite"],
        ["studentname" => "Payal Joshi", "email" => "payaljoshi18@gmail.com", "contact" => "9876543210", "mode" => "onsite"],
        ["studentname" => "Urvshi Mehta", "email" => "urvshimehta20@gmail.com", "contact" => "9876543217", "mode" => "onsite"],
        ["studentname" => "Hina Thanki", "email" => "hinathanki2008@gmail.com", "contact" => "9123456702", "mode" => "onsite"],
        ["studentname" => "Raj Modha", "email" => "rajmodha2006@gmail.com", "contact" => "9876543210", "mode" => "hybrid"],
        ["studentname" => "Jagruti Thanki", "email" => "jaguthanki2006@gmail.com", "contact" => "9876543267", "mode" => "hybrid"]
    ];

    $selectedMode = $_GET['mode'];
    $found = false;

    foreach ($internships as $row) {
        if ($selectedMode == 'all' || $row['mode'] == $selectedMode) {
            $found = true;
            echo "<tr>";
            echo "<td>" . $row['studentname'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['contact'] . "</td>";
            echo "<td>" . $row['mode'] . "</td>";
            echo "</tr>";
        }
    }

    if (!$found) {
        echo "<tr><td colspan='4' style='color:red; text-align:center;'>No records found.</td></tr>";
    }
    
    exit; 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Internship Portal</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        /* Basic Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: lightpink;
        }

        select {
            padding: 8px;
            font-size: 16px;
        }
    </style>

    <script>
    function filterInternship(modeValue) {
        var tbody = document.getElementById("table-body");

        if (modeValue === "") {
            tbody.innerHTML = "<tr><td colspan='4' style='text-align:center;'>Please select a mode.</td></tr>";
            return;
        }

        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Put the raw rows from PHP inside the table body
                tbody.innerHTML = xhr.responseText;
            }
        };

        xhr.open("GET", "?mode=" + modeValue, true);
        xhr.send();
    }
    </script>
</head>
<body>

    <h2>Internship Portal</h2>

    <label>Select Mode: </label>
    <select onchange="filterInternship(this.value)">
        <option value="">-- Select --</option>
        <option value="online">Online</option>
        <option value="onsite">Onsite</option>
        <option value="hybrid">Hybrid</option>
        <option value="all">Show All</option>
    </select>

    <table border="1">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Mode</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                <td colspan="4" style="text-align:center;">Please select a mode.</td>
            </tr>
        </tbody>
    </table>

</body>
</html>