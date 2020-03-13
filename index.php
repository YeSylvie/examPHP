<?php
    session_start();

    $controller = isset($_GET['controller']) ? $_GET['controller'] : '';
    //    echo $controller;

    if(file_exists(__DIR__."/controllers/".$controller."_controller.php")) {
        include_once(__DIR__.'/controllers/'.$controller.'_controller.php');
    }