<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_project;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    // في مرحلة التطوير فقط، بعدها نخفي التفاصيل
    die("wrong connection :" . $e->getMessage());
}
?>
