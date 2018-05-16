<?php 
    include "DBConnection.php";
    
    $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

    switch($httpMethod) {
      case "OPTIONS":
        header("Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description");
        header("Access-Control-Allow-Methods: POST, GET");
        header("Access-Control-Max-Age: 3600");
        exit();
      case "GET":
        // Allow any client to access
        header("Access-Control-Allow-Origin: *");
        // Let the client know the format of the data being returned
        header("Content-Type: application/json");

        // TODO: do stuff to get the $results which is an associative array
        $results = array();

        // Sending back down as JSON
        echo json_encode($results);

        break;
      case 'POST':
        // Get the body json that was sent
        $rawJsonString = file_get_contents("php://input");

        //var_dump($rawJsonString);

        // Make it a associative array (true, second param)
        $jsonData = json_decode($rawJsonString, true);

        // TODO: do stuff to get the $results which is an associative array
        $results = array();

        // Allow any client to access
        header("Access-Control-Allow-Origin: *");
        // Let the client know the format of the data being returned
        header("Content-Type: application/json");

        // Sending back down as JSON
        echo json_encode($results);

        break;
        break;
    }
    
    $conn = getDataBaseConnection(`final`);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Schedule Time</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <script src="func.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
        </script>
    </head>
    <body>
        <img src="" alt="banner">
        <script>
            display();
        </script>
        <form method="post" action="addTimeSlot.php">
            Start Date: <input type = "text" name="startDate"><br>
              End Date: <input type = "text" name="endDate"><br>
            Start Time: 
            <select name="startTime">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select><br>
            Number of Appointments: <select name="numOfAppt">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select><br>
            
            <button id="submit" value="Add Times" onclick="onSubmitClick(event)">Add Times</button>
            <?php
                if (isset($_POST['startDate']))
                { $startDate = $_POST['startDate']; }
                if (isset($_POST['endDate']))
                { $endDate = $_POST['endDate']; }
            
                $sql = "INSERT INTO `Schedule` ('start_date', 'end_date')
                    VALUES ('$startDate', '$endDate')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $sql="SELECT * FROM `Schedule`";
                
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $records = $stmt->fetchALL(PDO::FETCH_ASSOC);
            
                foreach($records as $record){
                    echo $record['date'];
                }
            ?>    
        </form>
       <?php
            if (isset($_POST['uploadForm'])) {
                if ($_FILES["fileName"]["error"] > 0) {
                    echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
                }
                else {
                  echo "Upload: " . $_FILES["fileName"]["name"] . "<br>";
                  echo "Type: " . $_FILES["fileName"]["type"] . "<br>";
                  echo "Size: " . ($_FILES["fileName"]["size"] / 1024) . " KB<br>";
                  echo "Stored in: " . $_FILES["fileName"]["tmp_name"];
                }  
            }//endIf form submission
        ?>
        <form method="POST" enctype="multipart/form-data"> 
            Select file: <input type="file" name="fileName" /> <br />
            <input type="submit"  name="uploadForm" value="Upload File" /> 
        </form>

    </body>
</html>