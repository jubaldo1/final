<!DOCTYPE html>
<html>
    <head>
        <title>Add Time Slot</title>
    </head>
    <body>
        <h3>Add Times</h3>
        <?php
            if (isset($_POST['startDate']))
            { 
                $startDate = $_POST['startDate'];
                echo $startDate;
            }
            if (isset($_POST['endDate']))
            { 
                $endDate = $_POST['endDate'];
                echo $endDate;
            }
        
            $sql = "INSERT INTO `Schedule` ('start_date', 'end_date')
                VALUES ('$startDate', '$endDate')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            $sql="SELECT * FROM `Schedule`";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $records = $stmt->fetchALL(PDO::FETCH_ASSOC);
        
            foreach($records as $record)
            { echo $record['date']; }
            
            header('Location: schedule.php');
        ?>  
    </body>
</html>