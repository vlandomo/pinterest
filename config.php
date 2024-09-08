<?php
 // الاتصال بقاعدة البيانات
 $servername = "localhost";
 $username = "root";  // اسم المستخدم الافتراضي
 $password = "";      // كلمة المرور الافتراضية
 $dbname = "pinterestapp"; // تعديل اسم قاعدة البيانات
 // إنشاء الاتصال
 $conn = mysqli_connect($servername, $username, $password, $dbname);
 // التحقق من الاتصال
 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }
?>