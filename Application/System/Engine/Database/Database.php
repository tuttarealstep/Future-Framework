<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 11/09/2015 Time: 19:56
 */

defined('R_PATH') OR exit('No Direct Script');

function &Database_Initialize($type = "Mongo"){

    if(empty($type)){
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Database type is empty!';
        exit(2);
    }

    switch($type){
        case 'Mongo':
            $parameters = null;
            $_db_driver = "Mongo_Driver";
            break;
        case 'MySQL':
            $parameters = null;
            $_db_driver = "MySQL_Driver";
            break;
        default:
            header('HTTP/1.1 503 Service Unavailable', true, 503);
            echo 'Database type not found!';
            exit(2);
            break;
    }

    if(!isset($_db_driver) || $_db_driver == "" || !file_exists( LIBRARIES_PATH . DIRECTORY_SEPARATOR . "Connection" . DIRECTORY_SEPARATOR . "Database" . DIRECTORY_SEPARATOR . "Drivers" . DIRECTORY_SEPARATOR . $_db_driver.".php")){
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Database driver not found - Error!';
        exit(2);
    }

    require_once ( LIBRARIES_PATH . DIRECTORY_SEPARATOR . "Connection" . DIRECTORY_SEPARATOR . "Database" . DIRECTORY_SEPARATOR . "Drivers" . DIRECTORY_SEPARATOR . $_db_driver.".php" );

    if(!class_exists($_db_driver)){
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Database class not found - Error!';
        exit(2);
    }

    $Database = new $_db_driver($parameters);
    return $Database;
}