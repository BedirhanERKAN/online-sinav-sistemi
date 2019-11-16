<?php

    $sinavBasladimi  = false;
    if($sinavBasladimi)
    {
        exit;
    }

    if(file_exists("skortablosu.html"))
    {   
        require_once("skortablosu.html");
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Online Sınav Sistemi v0.0.1 </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://unpkg.com/jquery"></script>
    <script src="survey.jquery.js"></script>
    <link href="survey.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="index.css">
    <meta charset="utf-8">
</head>

<body>
    <div id="surveyElement"></div>
    <div id="surveyResult"></div>

    <script type="text/javascript" src="index.js"></script>
</body>
</html>