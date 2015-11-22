<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 09/09/2015 Time: 10:52
 */


$connection_settings = [
    'database_enabled' => true,
    'database_driver' => 'Mongo', //MySQL, Mongo

    'mysql_host' => 'localhost',
    'mysql_port' => '3306',
    'mysql_database' => 'framework_test',
    'mysql_user_username' => 'root',
    'mysql_user_password' => '',

    'mongo_host' => 'localhost',
    'mongo_port' => '27017',
    'mongo_database' => 'FutureSystem',
    'mongo_user_username' => '',
    'mongo_user_password' => ''
];

$web_settings = [
    'siteURL' => 'http://localhost',
    'siteTEMPLATE' => 'default',
    'small_url' => true, //Need mod_rewrite - NOT WORKING
    'first_controller_class' => 'Test_Page_Controller'
];

define("SECURITY_KEY", "7018d63f15fSD9R58CId1c8f7d8eb50e71feddf2cd4d241f62");