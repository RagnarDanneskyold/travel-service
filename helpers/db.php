<?
try {
    $db = new PDO('mysql:host=localhost; dbname=card-land', 'root', '');
} catch (PDOException $e) {
    die($e->getMessage());
}

?>