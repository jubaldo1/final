<?php 
    include "DBConnection.php";
    // start a session to pass data between the pages
    session_start();
    
    // create connection
    $conn = getDataBaseConnection(`final`);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Final Exam</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <script src="func.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
        </script>
        
        <script>
            display();
        </script>

    </head>
    <body>
        <!-- Do the HTML versions of creating the appointment
             then do the jQuery version -->
             
        <form method="post">
            Invitation link: <input type="text" name="invite"><br><br>
        </form>
        
        <table>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>Duration</th>
                <th>Booked by</th>
            </tr>
            <tr>
                <?php 
                    
                ?>
            </tr>
        </table>
        
        <script>
            console.log("do you see me?");
        
            // JSON object
            var data = {
                date : [],
                start : [],
                end : []
            }
            
            // first date
            data.date.push("05/01/2018");
            
            data.start.push("05:00");
            
            data.end.push("10:00");
            
            // second date
            data.date.push("05/11/2018");
            
            data.start.push("7:00");
            
            data.end.push("11:00");
            
            for (var i = 0; i < data['date'].length; i++)
            {
                console.log("just give me anything");
                console.log(data['date']);
            }
            
        </script>
        
        <?php 
            $json = json_decode(data);
            
            var_dump($json);
            
            // this is used to push data into the database
            $sql = "INSERT INTO `Schedule` ('date', 'start_time', 'end_time', 'user_id')
                    VALUES ('date11','star1','end1',1)";
                    
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        ?>
        
        <!-- adding an appointment -->
        <form>
            Date: <input type="text" name="date">
            From: <input type="text" name="start">
            To:   <input type="text" name="end">
        </form>
        
    </body>
</html>