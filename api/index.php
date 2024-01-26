<?php    

   //la infromación devuelta será en formato json en lugar de html
   header('Content-Type: application/json');
   require_once "./util/log.php";
   require_once "config.php";
   require_once "controllers/route.controller.php";
   
   $route = new RouteController();
   $route->start();

    //require_once "models/connection.php";
    //Connection::connect();

    //-----------------------------------------
    // funciones auxiliares globales
    //-----------------------------------------

/*     function line($string){
       echo "<br>".$string."<br>";
    } */