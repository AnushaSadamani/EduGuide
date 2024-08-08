<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
   exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h2 class="heading">Interact with our Experts</h2>
        <?php
        if (isset($_POST["submit"])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
            $email = $_POST['email'];
            $country = $_POST['country'];
            $number = $_POST['number'];

            $errors = array();

            // Validation
            if (empty($firstName) || empty($lastName) || empty($gender) || empty($email) || empty($country) || empty($number)) {
                array_push($errors, "All fields are required.");
            }

           else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Invalid email format.");
            }

          else  if (!preg_match('/^\d{10}$/', $number)) {
                array_push($errors, "Phone number must be 10 digits.");
            }

            if (count($errors) == 0) {
                require_once "database.php";
                $sql = "INSERT INTO registration (firstName, lastName, gender, email, country, , number) VALUES (?, ?, ?, ?, ?, ?, )";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $gender, $email, $country, $number);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                } else {
                    die("Something went wrong: " . mysqli_error($conn));
                }
            } else {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" />
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" />
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <div>
                    <label for="male" class="radio-inline">
                        <input type="radio" name="gender" value="m" id="male" /> Male
                    </label>
                    <label for="female" class="radio-inline">
                        <input type="radio" name="gender" value="f" id="female" /> Female
                    </label>
                    <label for="others" class="radio-inline">
                        <input type="radio" name="gender" value="o" id="others" /> Others
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" />
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <select class="form-control" id="country" name="country">
                    <option value="">Select Country</option>
                    <option value="DE">Germany</option>
                    <option value="IE">Ireland</option>
                    <option value="NL">Netherlands</option>
                </select>
            </div>
            <div class="form-group">
                <label for="number">Phone Number</label>
                <input type="text" class="form-control" id="number" name="number" />
            </div>
            <input type="submit" class="btn btn-primary" value="Register" name="submit">
        </form>
    </div>
</body>
</html>
