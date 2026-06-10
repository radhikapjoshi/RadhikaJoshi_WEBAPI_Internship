<?php
$mess = "";

$first_nameErr = $middle_nameErr = $last_nameErr = $cityErr = $emailErr = $phoneErr = $genderErr = $aadhaar_noErr = $pan_noErr = $usernameErr = $passwordErr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    $valid = true; // Assume the form is valid until an error is found

    
    if (empty($_POST["first_name"])) 
    {
        $first_nameErr = "First name is required";
        $valid = false;
    } 
    else 
    {
        $first_name = trim($_POST["first_name"]);
        if (!preg_match("/^[a-zA-Z ]+$/",$first_name)) 
        {
            $first_nameErr = "letter's is allowed";
            $valid = false;
        }
    }

   
    if (!empty($_POST["middle_name"])) 
    {
        $middle_name = trim($_POST["middle_name"]);
        if (!preg_match("/^[a-zA-Z ]+$/", $middle_name)) 
        {
            $middle_nameErr = "letter's is allowed";
            $valid = false;
        }
    } 
    else 
    {
        $middle_name = "";
    }

    
    if (empty($_POST["last_name"])) 
    {
        $last_nameErr = "Last name is required";
        $valid = false;
    } 
    else 
    {
        $last_name = trim($_POST["last_name"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) 
        {
            $last_nameErr = "letter's is allowed";
            $valid = false;
        }
    }

   
    if (!empty($_POST["city"])) 
    {
        $city = trim($_POST["city"]);
        if (!preg_match("/^[a-zA-Z\s]*$/", $city)) 
        {
            $cityErr = "letter's is allowed";
            $valid = false;
        }
    } 
    else 
    {
        $city = "";
    }

   
    if (empty($_POST["email"])) 
    {
        $emailErr = "Email is required";
        $valid = false;
    } 
    else 
    {
        $email = trim($_POST["email"]);
        if (!preg_match("/^[\w\.-]+@[\w\.-]+\.\w+$/",$email)) 
        {
            $emailErr = "add valid email";
            $valid = false;
        }
    }

   
    if (!empty($_POST["phone"])) 
    {
        $phone = trim($_POST["phone"]);
        if (!preg_match("/^[6-9]\d{9}$/", $phone)) 
        {
            $phoneErr = "add valid number according to india";
            $valid = false;
        }
    } 
    else 
    {
        $phone = "";
    }

   
    if (empty($_POST["gender"])) 
    {
        $genderErr = "gender must be requried";
        $valid = false;
    } 
    else 
    {
        $gender = trim($_POST["gender"]);
    }

   
    if (!empty($_POST["aadhaar_no"])) 
    {
        $aadhaar_no = htmlspecialchars(trim($_POST["aadhaar_no"]));
        if (!preg_match("/^\[2-9]{1}[0-9]{11}$/", $aadhaar_no)) 
        {
            $aadhaar_noErr = "add must 12 digits";
            $valid = false;
        }
    } 
    else 
    {
        $aadhaar_no = "";
    }

    if (!empty($_POST["pan_no"])) 
    {
        $pan_no = trim($_POST["pan_no"]);
        if (!preg_match("/^[A-Z]{5}[0-9]{4}[A-Z]$/", $pan_no)) 
        {
            $pan_noErr = "added only valid aadhaar";
            $valid = false;
        }
    } else {
        $pan_no = "";
    }

    
    if (empty($_POST["username"])) 
    {
        $usernameErr = "Username is required";
        $valid = false;
    } 
    else 
    {
        $username = trim($_POST["username"]);
        if (!preg_match("/^[A-Za-z0-9_]{4,20}$/", $username)) 
        {
            $usernameErr = "letter,min= (4)charcter,max = (20)charcter and '_'only valid";
            $valid = false;
        }
    }

   
    if (empty($_POST["password"])) 
    {
        $passwordErr = "password is required";
        $valid = false;
    } 
    else 
    {
        $password = $_POST["password"];
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) 
        {
            $passwordErr = "only allowed uppercase, lowercase, number, special character and at least 8 character";
            $valid = false;
        }
    }

   
    if ($valid)
    {
        $mess = "<p style='color: green; font-weight: bold;'>Registration successful for $first_name!</p>";
        
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <style>
        /* Centering the entire layout on the screen */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ffc0cb;
            padding: 20px;
        }

        /* Styling the unified form box */
        form {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px 30px;
            box-sizing: border-box;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .error-text {
            color: red;
            font-size: 0.8em;
            margin-top: 3px;
            display: block;
        }

        button {
            width: 100%;
            padding: 10px 15px;
            background-color: #ff1493;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #c71585;
        }
    </style>
</head>
<body>
   
    <h2>REG EXPRETIONS REGISTRATION FORM</h2>
   

    <form method="POST">
        
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="Enter your first name">
            <span class="error-text"><?php echo $first_nameErr; ?></span>
        </div>

        <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" placeholder="Enter your middle name">
            <span class="error-text"><?php echo $middle_nameErr; ?></span>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Enter your last name">
            <span class="error-text"><?php echo $last_nameErr; ?></span>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" placeholder="Enter your city">
            <span class="error-text"><?php echo $cityErr; ?></span>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email address">
            <span class="error-text"><?php echo $emailErr; ?></span>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" placeholder="Enter your 10-digit phone number">
            <span class="error-text"><?php echo $phoneErr; ?></span>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <input type="radio" name="gender" value="male" required> Male
            <input type="radio" name="gender" value="female"> Female
            <span class="error-text"><?php echo $genderErr; ?></span>
        </div>

        <div class="form-group">
            <label>Aadhaar Number</label>
            <input type="tel" name="aadhaar_no" placeholder="[Aadhaar Redacted]">
            <span class="error-text"><?php echo $aadhaar_noErr; ?></span>
        </div>

        <div class="form-group">
            <label>PAN Card Number</label>
            <input type="text" name="pan_no" placeholder="Enter your PAN card number">
            <span class="error-text"><?php echo $pan_noErr; ?></span>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Choose a username">
            <span class="error-text"><?php echo $usernameErr; ?></span>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Create a secure password">
            <span class="error-text"><?php echo $passwordErr; ?></span>
        </div>

        <button type="submit">Submit Registration</button>
    </form>

</body>
</html>:my reg exprestion code