<?php

if(getenv("ENVIRONMENT") == "prod")
{
    $url = "http://www.jqt3of5.com/kslnotify/";
    $database_url = "localhost";
    $database = "kslnotify";
    $username = "kslnotify";
    $password = '2Qe4g6F@ui45';

    
}
else if(getenv("ENVIRONMENT") == "test")
{
    $url = "http://www.jqt3of5.com:8080";
    $database_url = "localhost";
    $database = "kslnotify_test";
    $username = "kslnotify_test";
    $password = "password";
}
?>