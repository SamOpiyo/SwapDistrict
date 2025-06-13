
<?php
require 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = 1;
    $occupation = strtolower(trim($_POST['occupationSwap'] ?? ''));
    $designation = strtolower(trim($_POST['designationSwap'] ?? ''));
    $current_sub = strtolower(trim($_POST['currentSubcounty'] ?? ''));
    $preferred_sub = strtolower(trim($_POST['preferredSubcounty'] ?? ''));
    $preferred1 = strtolower(trim($_POST['preferredInstitution1'] ?? ''));
    $preferred2 = strtolower(trim($_POST['preferredInstitution2'] ?? ''));
    $preferred3 = strtolower(trim($_POST['preferredInstitution3'] ?? ''));
    $current_institution = strtolower(trim($_POST['currentInstitution'] ?? ''));
    $subjects = strtolower(trim($_POST['subjectsSwap'] ?? ''));

    $stmt = $pdo->prepare("INSERT INTO swap_requests 
        (user_id, occupation, designation, current_sub_county, preferred_sub_county, 
         preferred_institution_1, preferred_institution_2, preferred_institution_3, 
         current_institution, subjects)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    try {
        $stmt->execute([$user_id, $occupation, $designation, $current_sub, $preferred_sub,
                        $preferred1, $preferred2, $preferred3, $current_institution, $subjects]);

        $matchQuery = $pdo->prepare("SELECT * FROM swap_requests 
            WHERE occupation = ? AND designation = ? 
              AND current_sub_county = ? AND preferred_sub_county = ?
              AND preferred_institution_1 = ?");

        $matchQuery->execute([
            $occupation, $designation,
            $preferred_sub, $current_sub,
            $current_institution
        ]);

        if ($matchQuery->fetch()) {
            echo "<script>alert('🎉 Match found!'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('❌ No match found yet. Try again later.'); window.location.href='index.html';</script>";
        }

    } catch (Exception $e) {
        echo "❌ Error inserting swap request: " . $e->getMessage();
    }
}
?>
