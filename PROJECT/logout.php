<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
</head>
<body>
<?php
session_start();

session_destroy();
?>


<h1 id='login' align='center'>Uspesno ste se izlogovali</h1>
<?php
header("refresh:1.5;url=index.php");
?>


</body>
</html>



