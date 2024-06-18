<!DOCTYPE html>
<html>
<head>
    <title>Zadanie 9 - WWW i Języki Skryptowe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <link rel="stylesheet" type="text/css" href="/155372/zadanie9/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/155372/zadanie9/zadanie.js"></script>
</head>
<!--  body --->
<body>
<!-- main page header --->    
<header>
  <h1>
      Zadanie 9
  </h1>
  <h2>
      Forum - CodeIgniter - zastosowanie szkieletu aplikacji 
  </h2>
</header>
<!--  main page NAV --->
<nav>
        <a href="../">Home</a>
        <?php for($n=1;$n<=10;$n++) { if( is_dir("../zadanie".$n) ) { ?>
        <a href="../zadanie<?=$n?>">Zadanie <?=$n?></a>
        <?php } } ?>
</nav>