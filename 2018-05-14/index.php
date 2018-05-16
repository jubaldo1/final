<?php 

    function createImage(){
                $sourcefile = imagecreatefromstring(file_get_contents($_FILES["fileName"]["tmp_name"]));
                $newx = 500; $newy = 200;  //new size
                $thumb = imagecreatetruecolor($newx,$newy);
                imagecopyresampled($thumb, $sourcefile, 0,0,0,0, $newx, $newy,     
                imagesx($sourcefile), imagesy($sourcefile)); 
                imagejpeg($thumb,"img/banner.jpg"); //creates jpg image file called "banner.jpg"
                echo "<img src='img/banner.jpg' alt='banner'/>";
            }
            
            function filterUploadedFile() {
                $allowedTypes = array("text/plain","image/png",
                                      "image/jpg", "image/jpeg", "image/gif");
                $allowedExtensions = array("txt", "png", "jpg", "jpeg", "gif");
                $allowedSize = 10000;
                $filterError = "";
                
                // check file types
                if (!in_array($_FILES["fileName"]["type"], $allowedTypes))
                {
                    $filterError = "Invalid type. <br>";
                }
                
                // check file name
                $filename = $_FILES["fileName"]["name"];
                if (!in_array(substr($filename, strpos($filename, ".") + 1), $allowedExtensions))
                {
                    $filterError = "Ivalid extension. <br>";
                }
                
                if (($_FILES["fileName"]["size"]/1024) > $allowedSize)
                {
                    $filterError = "File size is too big.<br>";
                }
                
                return $filterError;
            }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Salon</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type='text/javascript'>
        // AJAX calls
        
        /* global $ */
        /* global data */
        $(document).ready( function(){
           /*
        $( ".displayPages").load( "index.php", function() {
          for (var i = 0; i<data.length; i++)
                        { //$('element').attr('id', 'value');
                           $(".displayPages").append("<tr>")
                            .append("<td>"+data[i].code+"</td>")
                            .append("<td>"+data[i].available_from+"</td>")
                            .append("<td>"+data[i].available_to+"</td>")
                            .append("<td>"+data[i].type+"</td>")
                            .append("<td>"+data[i].isArchived+"</td>")
                            .append("<button>Edit</button>").attr('id','edit')
                            .append("<button>Archive</button>").attr('id','archive')
                            .append("<tr>");
                        }
        });*/
            
            $(".displayPages").append("<table border=1>")
                        .append("<tr>")
                        .append("<td>|-- Code --</td>")
                        .append("<td>-- Available from --</td>")
                        .append("<td>- to --</td>")
                        .append("<td>-- Type --</td>")
                        .append("<td>-- Archived --|</td>")
                        .append("<tr>")
                        .append("</table>");
            
            $("#edit").click(function(){
                alert('Glad that worked.');
                console.log("Did this work? Probably not.")
                $("#myModal").modal();
            });
            
            $("#submit").click(function() {    
                $.ajax({
                    type: "GET",
                    url: "apiEndpoint.php",
                    dataType: "json", 
                    success: function(data,status) {
                        for (var i = 0; i<data.length; i++)
                        { //$('element').attr('id', 'value');
                           $(".displayPages").append("<tr>")
                            .append("<td>"+data[i].code+"</td>")
                            .append("<td>"+data[i].available_from+"</td>")
                            .append("<td>"+data[i].available_to+"</td>")
                            .append("<td>"+data[i].type+"</td>")
                            .append("<td>"+data[i].isArchived+"</td>")
                            .append("<button>Edit</button>").attr('id','edit')
                            .append("<button>Archive</button>").attr('id','archive')
                            .append("<tr>");
                        }
                        
                        $(".displayPages").append("</table>");
                    },
                    complete: function(data,status) { 
                        // optional, used for debugging purposes
                        //alert("Data GET: " + data.answer + "<br>Status GET: " + status);
                    },
                    error: function(err) {
                        alert("Error GET: " + err);
                        $("#errorModal").modal();
                        $(".modal-error-body").append("<p>" + err.responseText + "</p>");
                    }
                }); // end of ajax GET
                
                
                // remove the "pages", repopulate
                //$(".displayPages").remove();
                
                var data = {
                    "available_from": $("#from").val(),
                    "available_to": $("#to").val(),
                    "code": $("#code").val(),
                    "type": $("#type").val(),
                    "status": $("#status").val(),
                    "title": $("#title").val(),
                    "slogan": $("#slogan").val(),
                    "action": $("#action").val()
                }
                
                console.log(JSON.stringify(data));
                
                $.ajax({
                          type: "post",
                          url: "apiEndpoint.php",
                          dataType: "json",
                          contentType: "application/json",
                          data: JSON.stringify(data),
                          success: function(data, status) {
                              console.log("Response " + data);
                          },
                          complete: function(data, status) {
                            //optional, used for debugging purposes
                            console.log(status);
                          },
                          error: function(err) {
                              $("#errorModal").modal();
                              $(".modal-error-body").append("<p>" + err.responseText + "</p>");
                          }
                    });
                });
            });
            
        </script>
    </head>
    <body>
        <div align="center">
            <?php
                createImage();
            ?>
        </div>
        
        
        <div align="center">
            <h3><b>Final Exam: Salon</b></h3>
        </div>
        
        <div class="container">
            <button type="button" class="btn btn-info btn-lg"
                    data-toggle="modal" data-target="#myModal">+</button>
            
            <!--Modal-->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    
                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Create New Landing Page</h4>
                        </div>
                        <div class="modal-body">
                            <p>Fill in basic info below for new landing page:</p>
                            
                            <!--Form inside the modal to create landing page-->
                            <form method="post">
                                Available From <input type="date" id="from">
                                to <input type="date" id="to"><br>
                                Code: <input type="text" id="code"> e.g. Nails<br><br>
                                Type:
                                <select id="type">
                                  <option value="standard">Standard</option>
                                  <option value="holiday">Holiday</option>
                                  <option value="special">Special</option>
                                </select>
                                <select id="status">
                                  <option value="onhold">On Hold</option>
                                  <option value="Archived">Archived</option>
                                </select><br><br>
                                Title: <input type="text" id="title"><br><br>
                                Slogan: <input type="text" id="slogan"><br><br>
                                Action: <input type="text" id="action"><br><br>
                                Description: <input type="text" id="describe">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class = "btn btn-default" data-dismiss="modal" id="submit">Save</button>
                            <button type="button" class = "btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
          <div class="modal fade" id="errorModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Error Modal</h4>
                    </div>
                    <div class="modal-error-body">
                      <p>Error: </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </div>
        
        
        <div class="displayPages">
            
        </div>
        
        <div align="center" >
            Only works with some images:<br>
            <form method="POST" enctype="multipart/form-data"> 
            Select file: <input type="file" name="fileName" /> <br />
            <input type="submit"  name="uploadForm" value="Upload File" /> 
            </form>
        </div>
    </body>
    <footer>
        <table>
        <thead>
        <tr>
        <th style="text-align:left">#</th>
        <th style="text-align:left">Task Description</th>
        <th style="text-align:left">Points</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td style="text-align:left">1</td>
        <td style="text-align:left">You provide a ERD diagram representing the data and its relationships, with at least one trasactional and one code table. This may be included in Cloud9 as a picture or from a designer tool</td>
        <td style="text-align:left">10</td>
        </tr>
        <tr>
        <td style="text-align:left">2</td>
        <td style="text-align:left">Tables in MySQL match the ERD and support the requirements of the application</td>
        <td style="text-align:left">20</td>
        </tr>
        <tr>
        <td style="text-align:left">3</td>
        <td style="text-align:left">The list of landing pages is pulled from MySQL using the API endpoint and displayed using the specified page design</td>
        <td style="text-align:left">10</td>
        </tr>
        <tr>
        <td style="text-align:left">4</td>
        <td style="text-align:left">Archived landing pages do not show up in the Dashboard list</td>
        <td style="text-align:left">5</td>
        </tr>
        <tr>
        <td style="text-align:left">5</td>
        <td style="text-align:left">A user can add a landing page to the MySQL using the API endpoint and displayed using the specified modal design</td>
        <td style="text-align:left">10</td>
        </tr>
        <tr>
        <td style="text-align:left">6</td>
        <td style="text-align:left">A user can archive a landing page in MySQL using the API endpoint</td>
        <td style="text-align:left">5</td>
        </tr>
        <tr>
        <td style="text-align:left">7</td>
        <td style="text-align:left">The user confirms the archival using the specified modal design</td>
        <td style="text-align:left">0</td>
        </tr>
        <tr>
        <td style="text-align:left"></td>
        <td style="text-align:left">TOTAL</td>
        <td style="text-align:left">60</td>
        </tr>
        <tr>
        <td style="text-align:left"></td>
        <td style="text-align:left">This rubric is properly included AND UPDATED (BONUS)</td>
        <td style="text-align:left">2</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">Login works with a User table and BCrypt</td>
        <td style="text-align:left">0</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">The app is deployed to Heroku</td>
        <td style="text-align:left">0</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">A banner file can be uploaded and displayed</td>
        <td style="text-align:left">15</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">The landing page shows the information for the correct URL</td>
        <td style="text-align:left">0</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">Users can see all the archived landing pages</td>
        <td style="text-align:left">0</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">Users can filter records based on text that is showing</td>
        <td style="text-align:left">0</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">The Copy to Clipboard button copies the correct URL to the clipboard</td>
        <td style="text-align:left">0</td>
        </tr>
        <tr>
        <td style="text-align:left">BD</td>
        <td style="text-align:left">Status report shows all statuses, even those that do not have landing pages</td>
        <td style="text-align:left">0</td>
        </tr>
        </tbody>
        </table>
    </footer>
</html>