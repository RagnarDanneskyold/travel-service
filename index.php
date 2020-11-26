<?php 
     require_once $_SERVER['DOCUMENT_ROOT'].'/controllers/mainController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel-service</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <div class="container">
        <h1 class="main-title"> Здравствуй дорогой путешественник!</h1>
        <p class="choose">Выбирай, какую информацию ты хочешь получить: о городах, о достопримечательностях или список наших участников?</p>
        <div class="wrap">
            <div class="btn-wrap">
                <button class="btn cities-btn"> Города </button>
                <button class="btn sightseens-btn"> Достопримечательности </button>
                <button class="btn users-btn"> Участники </button>
            </div>
            <div class="result-block res-hidden">
                <p class="result"></p>
            </div>
        </div>
    </div>
    <script>

    </script>
<script src="main.js"></script>
</body>
</html>