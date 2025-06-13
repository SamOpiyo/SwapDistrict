
<?php
require 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $designation = $_POST['designation'] ?? '';
    $county = $_POST['county'] ?? '';
    $subcounty = $_POST['subcounty'] ?? '';
    $institution = $_POST['institution'] ?? '';
    $subjects = $_POST['subjects'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO users 
        (phone, email, occupation, designation, county, sub_county, institution, subjects, registered_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    try {
        if ($stmt->execute([$phone, $email, $occupation, $designation, $county, $subcounty, $institution, $subjects])) {
            echo "✅ Registration successful! Proceed to find a swapmate.";

        } else {
            echo "❌ Insert failed.";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>
