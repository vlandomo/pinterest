<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
        }
        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>File Upload</h2>

<!-- PHP for File Upload Handling -->
<?php
include("config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "Upload_Images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $maxSize = 100 * 1024 * 1024; // 100MB
    $File_Description = $_POST['description'];  // الوصف من المستخدم

    // التحقق إذا كان الملف مختارًا
    if (empty($_FILES["fileToUpload"]["name"])) {
        echo "<div class='message error'>Please select a file to upload.</div>";
        $uploadOk = 0;
    }

    // التحقق من حجم الملف
    if ($_FILES["fileToUpload"]["size"] > $maxSize) {
        echo "<div class='message error'>Your file is too large. Max size: 100MB.</div>";
        $uploadOk = 0;
    }

    // أنواع الملفات المسموح بها
    $allowedTypes = array("jpg", "png");
    if (!in_array($fileType, $allowedTypes)) {
        echo "<div class='message error'>Only JPG, PNG files are allowed.</div>";
        $uploadOk = 0;
    }

    // التحقق من نجاح الفحوصات
    if ($uploadOk == 0) {
        echo "<div class='message error'>Sorry, your file was not uploaded.</div>";
    } else {
        // محاولة رفع الملف
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // عرض رسالة النجاح
            echo "<div class='message success'>The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.</div>";
            
            // إدخال البيانات في قاعدة البيانات
            $File_Name = basename($_FILES["fileToUpload"]["name"]); // اسم الملف
            $File_Path = $target_file; // المسار الكامل للملف
            $stmt = $conn->prepare("INSERT INTO pinterest_db (File_Name, File_Path, File_Description) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $File_Name, $File_Path, $File_Description);
            
            // استعلام لإدخال البيانات في الجدول
            if ($stmt->execute()) {
                echo "<div class='message success'>File information saved to the database.</div>";
            } else {
                echo "<div class='message error'>Error: " . $stmt->error . "</div>";
            }
        } else {
            echo "<div class='message error'>Sorry, there was an error uploading your file.</div>";
        }
    }
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>



        <!-- Form for file upload -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="fileToUpload" id="fileToUpload" required>
            </div>
            <div class="form-group">
                <input type="text" name="description" placeholder="Enter file description (optional)">
            </div>
            <div class="form-group">
                <input type="submit" value="Upload File" name="submit">
                <a href="http://localhost/MyApps/PintrestApp/index1.php">go back</a>
            </div>
        </form>
    </div>

</body>
</html>
