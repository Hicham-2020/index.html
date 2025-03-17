<?php
// معلمات الاتصال بقاعدة البيانات
    $serverName = "DESKTOP-JGFU26C";
    $connectionOptions = array(
        "Database" => "syngeb", 
        "Uid" => "sa", 
        "PWD" => "Aa123456*", 
        "CharacterSet" => "UTF-8"
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    // التحقق من الاتصال
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['FirstName'] ?? '';
    $lastName = $_POST['lastName']?? '';
    $birthDate = $_POST['birthDate']?? '';
    $birthPlace = $_POST['birthPlace']?? '';
    $gender = $_POST['gender']?? '';
    $address = $_POST['address']?? '';
    $level = $_POST['level']?? '';
    $phoneNumber = $_POST['phoneNumber']?? '';
    $email = $_POST['email']?? '';

    // معالجة الملفات
    $photoPath = 'uploads/' . basename($_FILES['photo']['name']);
    $idCardPath = 'uploads/' . basename($_FILES['idCard']['name']);
    $commitmentPath = 'uploads/' . basename($_FILES['commitment']['name']);

    move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
    move_uploaded_file($_FILES['idCard']['tmp_name'], $idCardPath);
    move_uploaded_file($_FILES['commitment']['tmp_name'], $commitmentPath);

    $sql = "INSERT INTO Users (FirstName, LastName, BirthDate, BirthPlace, Gender, address, level, PhoneNumber, Email, PhotoPath, IDCardPath, CommitmentPath)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $params = array($firstName, $lastName, $birthDate, $birthPlace, $gender, $address, $level, $phoneNumber, $email, $photoPath, $idCardPath, $commitmentPath);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        echo "تم تسجيل البيانات بنجاح!";
    } else {
        echo "حدث خطأ أثناء الحفظ: " . print_r(sqlsrv_errors(), true);
    }
}
?>
