<?php
function getDataBaseConnection($opt){
    $host = 'localhost';
    $dbname = $opt;         // database connection, name of database assigned to name
    $username='jubaldo';
    $password='';           // blank b/c no password
    
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);   // PDO: php data object
    
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);          // ERRMODE: error thrown
    
    return $dbConn;
}
?>