<?php
    $connUrl = getenv('JAWSDB_MARIA_URL');
    //$connUrl = "mysql://z2hh9btwvx80bxcd:x9vev72h1nmhavyj@nt71li6axbkq1q6a.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/ntb9co1n6iciy160";
    $hasConnUrl = !empty($connUrl);

    $connParts = null;
    if ($hasConnUrl) {
        $connParts = parse_url($connUrl);
    }
    
    $host = $hasConnUrl ? $connParts['host'] : getenv('IP');
    $dbname = $hasConnUrl ? ltrim($connParts['path'],'/') : 'tech_checkout';
    $username = $hasConnUrl ? $connParts['user'] : getenv('C9_USER');
    $password = $hasConnUrl ? $connParts['pass'] : '';

    $dbConn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);   // PDO: php data object
    
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);          // ERRMODE: error thrown
?>