<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/helpers/db.php';
    
    if($_GET['cities']) {
      $data = $db->prepare("SELECT * FROM cities");
      $data->execute();
      $AllCities = json_encode($data->fetchAll(PDO::FETCH_ASSOC));
      echo $AllCities;
      
    }
    if($_GET['sightseens']) {
      $data = $db->prepare("SELECT 
      sightseen.name_sightseen as sightseen_name, sightseen.distance as distance_km,
      cities.name as city_name, ROUND(AVG(visited_sight.rating), 2) as rating 
      FROM sightseen 
      LEFT JOIN cities ON cities.id=sightseen.city_id 
      LEFT JOIN visited_sight ON sightseen.id=visited_sight.id_sightseen 
      GROUP BY id_sightseen
      ORDER BY rating DESC");
      $data->execute();
      $AllSightseens = json_encode($data->fetchAll(PDO::FETCH_ASSOC));
      echo $AllSightseens;
    }
    if($_GET['users']) {
      $data = $db->prepare("SELECT * FROM traveler");
      $data->execute();
      $AllUsers = json_encode($data->fetchAll(PDO::FETCH_ASSOC));
      echo $AllUsers;
    }
    if($_GET['citySight']) { 
      $id = $_GET['citySight'];
      $data = $db->prepare("SELECT
      cities.id,
      sightseen.name_sightseen as sightseen_name, sightseen.distance as distance_km,
      cities.name as city_name
      FROM sightseen
      LEFT JOIN cities ON cities.id=sightseen.city_id
      WHERE sightseen.city_id=$id
      ");
      $data->execute();
      $AllCitySight = json_encode($data->fetchAll(PDO::FETCH_ASSOC));
      echo $AllCitySight;
    }

    if($_GET['cityUsers']) { 
      $idCity = $_GET['cityUsers'];
      $data = $db->prepare("SELECT
      traveler.name
      FROM traveler
      LEFT JOIN traveler_route ON traveler.id=traveler_route.id_traveler
      WHERE traveler_route.id_city=$idCity
      ");
      $data->execute();
      $AllCityUsers = json_encode($data->fetchAll(PDO::FETCH_ASSOC));
      echo $AllCityUsers;
    }
    if($_GET['userCities']) { 
      $idUser = $_GET['userCities'];
      $data = $db->prepare("SELECT name
      FROM cities 
      LEFT JOIN traveler_route ON cities.id=traveler_route.id_city 
      WHERE traveler_route.id_traveler=$idUser
      ");
      $data->execute();
      $AllUserCities = json_encode($data->fetchAll(PDO::FETCH_ASSOC));
      echo $AllUserCities;
    }
    if($_GET['userSights']) { 
      $idUser = $_GET['userSights'];
      $data = $db->prepare("SELECT name_sightseen
      FROM sightseen 
      LEFT JOIN visited_sight ON visited_sight.id_sightseen=sightseen.id 
      WHERE visited_sight.id_traveler=$idUser
      ");
      $data->execute();
      $AllUserSights = json_encode($data->fetchAll(PDO::FETCH_ASSOC));
      echo $AllUserSights;
    }
    $db = null;