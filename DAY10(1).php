<?php
include('DAY10db_connect.php');

// Redirect to registration form if accessed directly via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registration.html");
    exit;
}

$errors = [];
$success = "";

// 1. Sanitize and retrieve POST data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phoneNumber'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$branch = trim($_POST['branch'] ?? '');

// 2. Validate Inputs
if ($name === '') {
    $errors['name'] = 'Full name is required.';
}
if ($email === '') {
    $errors['email'] = 'Email address is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}
if ($phone === '') {
    $errors['phone'] = 'Phone number is required.';
}
if ($dob === '') {
    $errors['dob'] = 'Date of birth is required.';
}
if ($gender === '') {
    $errors['gender'] = 'Gender selection is required.';
}
if ($branch === '') {
    $errors['branch'] = 'Please select your branch.';
}

// 3. File Upload handling (only if basic input validation passes)
$uploadedFileName = '';
$folder = "uploads/";
if (empty($errors)) {
    if (isset($_FILES['Myfile']) && $_FILES['Myfile']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $fileName = $_FILES['Myfile']['name'];
        $fileSize = $_FILES['Myfile']['size'];
        $fileTmp = $_FILES['Myfile']['tmp_name'];
        
        // Get file extension
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $maxsize = 20 * 1024 * 1024; // 20 MB

        if (!in_array($extension, $allowed_ext)) {
            $errors['file'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        } elseif ($fileSize > $maxsize) {
            $errors['file'] = "File size exceeds the limit of 20MB.";
        } else {
            // Generate a unique filename to prevent collisions
            $newFileName = uniqid() . '_' . basename($fileName);
            $destination = $folder . $newFileName;
            
            if (move_uploaded_file($fileTmp, $destination)) {
                $uploadedFileName = $newFileName;
            } else {
                $errors['file'] = "Error uploading file. Please try again.";
            }
        }
    } else {
        $errors['file'] = "Profile picture is required.";
    }
}

// 4. Save to Database if no errors
$db_success = false;
if (empty($errors)) {
    $name_esc = mysqli_real_escape_string($conn, $name);
    $email_esc = mysqli_real_escape_string($conn, $email);
    $phone_esc = mysqli_real_escape_string($conn, $phone);
    $dob_esc = mysqli_real_escape_string($conn, $dob);
    $gender_esc = mysqli_real_escape_string($conn, $gender);
    $branch_esc = mysqli_real_escape_string($conn, $branch);

    $sql = "INSERT INTO `skit` (`sn`, `name`, `email`, `phone`, `dob`, `gender`, `branch`) 
            VALUES (NULL, '$name_esc', '$email_esc', '$phone_esc', '$dob_esc', '$gender_esc', '$branch_esc')";

    if (mysqli_query($conn, $sql)) {
        $db_success = true;
        $success = "Registration completed successfully!";
    } else {
        $errors['db'] = "Database Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status</title>
    <link rel="stylesheet" href="DAY10style.css">
    <style>
        .status-card {
            max-width: 600px;
            width: 100%;
            margin: 40px auto;
            text-align: center;
        }
        .status-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .status-success {
            color: #10b981;
        }
        .status-error {
            color: #ef4444;
        }
        .info-list {
            text-align: left;
            background: var(--surface-soft);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            margin: 24px 0;
            list-style: none;
        }
        .info-list li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(15, 23, 42, 0.05);
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }
        .info-list li:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .info-value {
            color: var(--text);
            font-weight: 500;
            text-align: right;
            word-break: break-all;
        }
        .btn-back {
            display: inline-block;
            text-decoration: none;
            padding: 14px 28px;
            background: linear-gradient(90deg, #7c3aed 0%, #4f46e5 100%);
            color: #ffffff;
            border-radius: 16px;
            font-weight: 700;
            box-shadow: 0 16px 36px rgba(79, 70, 229, 0.18);
            transition: transform 0.2s;
        }
        .btn-back:hover {
            transform: translateY(-2px);
        }
        .error-box {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 16px;
            padding: 20px;
            color: #991b1b;
            text-align: left;
            margin-bottom: 24px;
        }
        .error-box h3 {
            margin-top: 0;
            color: #991b1b;
        }
        .error-box ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        .profile-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent);
            box-shadow: var(--shadow);
            margin: 15px auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="hero-card status-card">
            <?php if ($db_success): ?>
                <div class="status-icon status-success">✓</div>
                <h2><?php echo htmlspecialchars($success); ?></h2>
                <p class="hero-text" style="margin: 10px auto;">Your account has been created and your profile picture is uploaded.</p>
                
                <?php if ($uploadedFileName): ?>
                    <img src="<?php echo htmlspecialchars($folder . $uploadedFileName); ?>" alt="Profile Picture" class="profile-preview">
                <?php endif; ?>

                <ul class="info-list">
                    <li>
                        <span class="info-label">Full Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($name); ?></span>
                    </li>
                    <li>
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($email); ?></span>
                    </li>
                    <li>
                        <span class="info-label">Phone:</span>
                        <span class="info-value"><?php echo htmlspecialchars($phone); ?></span>
                    </li>
                    <li>
                        <span class="info-label">Date of Birth:</span>
                        <span class="info-value"><?php echo htmlspecialchars($dob); ?></span>
                    </li>
                    <li>
                        <span class="info-label">Gender:</span>
                        <span class="info-value"><?php echo ucfirst(htmlspecialchars($gender)); ?></span>
                    </li>
                    <li>
                        <span class="info-label">Branch:</span>
                        <span class="info-value"><?php echo htmlspecialchars($branch); ?></span>
                    </li>
                </ul>

                <a href="registration.html" class="btn-back">Go Back</a>
            <?php else: ?>
                <div class="status-icon status-error">✗</div>
                <h2>Registration Failed</h2>
                <p class="hero-text" style="margin: 10px auto; color: var(--text-muted);">Please check the errors below and try again.</p>
                
                <div class="error-box">
                    <h3>Errors:</h3>
                    <ul>
                        <?php foreach ($errors as $field => $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <a href="javascript:history.back()" class="btn-back">Go Back and Edit</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>