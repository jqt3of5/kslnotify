<?php

if(getenv("ENVIRONMENT") == "prod")
{
    $url = "http://www.jqt3of5.com/kslnotify/";
    $database_url = "localhost";
    $database = "kslnotify";
    $username = "kslnotify";
    $password = "'5#89@QX$h8";
}
else if(getenv("ENVIRONMENT") == "test")
{
    $url = "http://www.jqt3of5.com:8080/app/";
    $database_url = "localhost";
    $database = "kslnotify_test";
    $username = "kslnotify_test";
    $password = "password";
}
?>