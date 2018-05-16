<?php 
    /*
    *   This program uploads a file, specifically an image.
    */
    include "DBConnection.php";
            
            function createImage(){
                $sourcefile = imagecreatefromstring(file_get_contents($_FILES["fileName"]["tmp_name"]));
                $newx = 100; $newy = 500;  //new size
                $thumb = imagecreatetruecolor($newx,$newy);
                imagecopyresampled($thumb, $sourcefile, 0,0, 0,0, $newx, $newy,     
                imagesx($sourcefile), imagesy($sourcefile)); 
                imagejpeg($thumb,"banner.jpg"); //creates jpg image file called "thumb.jpg"
                echo "<img src='banner.jpg'/>";
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
        
            if (isset($_POST['uploadForm'])) {
                // function for filtering files
                $filterError = filterUploadedFile();
                
                if (empty($filterError))
                {
                    if ($_FILES["fileName"]["error"] > 0) {
                        echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
                    }
                    else {
                        echo "Upload: " . $_FILES["fileName"]["name"] . "<br>";
                        echo "Type: " . $_FILES["fileName"]["type"] . "<br>";
                        echo "Size: " . ($_FILES["fileName"]["size"] / 1024) . " KB<br>";
                        echo "Stored in: " . $_FILES["fileName"]["tmp_name"];
                    
                        // Database connection time/SQL
                        // need binary data
                        $binaryData = file_get_contents($_FILES["fileName"]["tmp_name"]);
                        
                        // connection, SQL statement
                        $conn = getDBConn("images");
                        
                        $sql = "INSERT INTO `up_files` (fileName, fileType, fileData)
                                VALUES (:fileName, :fileType, :fileData)";
                    
                        $stmt = $conn -> prepare($sql);
                        $stmt -> execute(array(":fileName"=>$_FILES["fileName"]["name"],
                                               ":fileType"=>$_FILES["fileName"]["type"],
                                               ":fileData"=>$binaryData));
                        echo "<br />File saved into database. <br /><br />";
                    }
                } //end empty($filterError)
                else
                {
                    echo $filterError;
                }
            } //endIf form submission
            createImage();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Uploading an Image</title>
    </head>
    <body>
    
        <form method="POST" enctype="multipart/form-data"> 
            Select file: <input type="file" name="fileName" /> <br />
            <input type="submit"  name="uploadForm" value="Upload File" /> 
        </form>
    </body>
</html>