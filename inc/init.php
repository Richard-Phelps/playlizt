<?php
    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    spl_autoload_register(function ($class) {
        require_once('classes/' . $class . '.php');
    });

    include('functions.php');

    $config     = new config();
    $db         = $config->db_connect();
    $page_title = get_page_title($_SERVER['REQUEST_URI']);
?>
