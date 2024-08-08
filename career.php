<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Guidance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .para {
            text-align: center;
            margin: 1rem 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .counselors {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        .counselor {
            background-color: #f9f9f9;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 45%;
        }
        .counselor h2 {
            margin-top: 0;
        }
        .form-container {
            margin-bottom: 2rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form input, form textarea {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            padding: 0.75rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 5px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Career Guidance</h1>
    </div>
    <p class="para">EDROX CONSULTANCY LLP is seeking highly motivated and skilled individuals for the following posts.</p>

    <div class="container">
        <div class="counselors">
            <div class="counselor">
                <h2>Counselor 1</h2>
                <p><strong>Name:</strong> Jane Doe</p>
                <p><strong>Experience:</strong> 10 years</p>
                <p><strong>Email:</strong> jane.doe@example.com</p>
                <p><strong>Specialization:</strong> Career Transition, Resume Building</p>
            </div>
            <div class="counselor">
                <h2>Counselor 2</h2>
                <p><strong>Name:</strong> John Smith</p>
                <p><strong>Experience:</strong> 8 years</p>
                <p><strong>Email:</strong> john.smith@example.com</p>
                <p><strong>Specialization:</strong> Interview Preparation, Career Planning</p>
            </div>
        </div>

        <div class="form-container">
            <?php
            if (isset($_POST["submit"])) {
                $firstName = $_POST['firstname'];
                $lastName = $_POST['lastname'];
                $email = $_POST['email'];
                $phno = $_POST['phno'];
                $message = $_POST['message'];

                $errors = array();

                // Validation
                if (empty($firstName) || empty($lastName) || empty($email) || empty($phno) || empty($message)) {
                    array_push($errors, "All fields are required.");
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Invalid email format.");
                } else if (!preg_match('/^\d{10}$/', $phno)) {
                    array_push($errors, "Phone number must be 10 digits.");
                }

                if (count($errors) == 0) {
                    require_once "database.php";
                    $sql = "INSERT INTO career (first_name, last_name, email, phno, messages) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $phno, $message);
                        if (mysqli_stmt_execute($stmt)) {
                            echo "<div class='alert alert-success'>You are registered successfully.</div>";
                        } else {
                            echo "<div class='alert alert-error'>Something went wrong: " . mysqli_error($conn) . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-error'>Something went wrong: " . mysqli_error($conn) . "</div>";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-error'>$error</div>";
                    }
                }
            }
            ?>
        </div>

        <h2>Get in Touch</h2>
        <form action="" method="post">
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phno" placeholder="Phone Number" required>
            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>      
</body>
</html>
