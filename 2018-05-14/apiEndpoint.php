<?php
include 'DBConnection.php';
$dbConn = getDatabaseConnection('Salon');
  session_start();

    $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

    switch($httpMethod) {
      case "OPTIONS":
        // Allows anyone to hit your API, not just this c9 domain
        header("Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description");
        header("Access-Control-Allow-Methods: POST, GET");
        header("Access-Control-Max-Age: 3600");
        exit();
      case "GET":
        $sql = "SELECT * FROM `LandingPage`
                WHERE isArchive <> 1 AND status <> 'Archived'";
        
        $statement = $dbConn->query($sql);
        $result = $statement -> fetchAll();

        echo json_encode($result);
        break;
      case "POST":
        $rawJsonString = file_get_contents("php://input");
        
        $jsonData = json_decode($rawJsonString, true);
        
        // inserts new landing page into the database
        $sql = "INSERT INTO LandingPage (avail_from, avail_to, code, type, status, title, slogan, action)
        VALUES (:from, :to, :code, :type, :status, :title, :slogan, :action)";
        
        $stmt = $dbConn->prepare($sql);
        $stmt->execute( array ( 
                              ':from' => $jsonData["available_from"],
                              ':to' => $jsonData["available_to"],
                              ':code' => $jsonData["code"],
                              ':type' => $jsonData["type"],
                              ':status' => $jsonData["status"],
                              ':title' => $jsonData["title"],
                              ':slogan' => $jsonData["slogan"],
                              ':action' => $jsonData["action"]));
        
        header("Access-Control-Allow-Origin: *");
        // Let the client know the format of the data being returned
        
        header("Content-Type: application/json");

        // Sending back down as JSON
        echo json_encode($results);
        break;
    }
?>