<?php
/**
 * MyCMS(TProgram) - Project
 *
 * Future Framework - MyCMS - Project
 * An open source framework for PHP!
 *
 * @author TProgram - MyCMS Dev Team
 * @package Future
 * @version 00.1
 * @since 00.1
 */

/**
 * - - - - - - - - - - - - - - -
 * Define FUTURE_MODE
 * - - - - - - - - - - - - - - -
 *
 * You can set this 2 mode:
 *     development
 *     production
 *
 */
define('FUTURE_MODE', isset($_SERVER['FUTURE_MODE']) ? $_SERVER['FUTURE_MODE'] : 'development');

switch ( FUTURE_MODE )
{
    case 'development':
            ini_set('display_errors', 1);
            error_reporting(-1);
        break;
    case 'production':
            ini_set('display_errors', 0);
            error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
        break;
    default:
            header('HTTP/1.1 503 Service Unavailable', true, 503);
            echo 'Wrong FUTURE_MODE setting!';
            exit(1);
        break;
}

/**
 * - - - - - - - - - - - - - - -
 * Set folder path variable
 * - - - - - - - - - - - - - - -
 *
 */
$_root_path = '';
$_application_path = 'Application';
$_configuration_path = 'Configuration';
$_framework_path = 'Framework';
$_framework_controllers_path = 'Controllers'; //In $_framework_path folder
$_framework_models_path = 'Models'; //In $_framework_path folder
$_framework_views_path = 'Views'; //In $_framework_path folder
$_libraries_path = 'Libraries';
$_system_path = 'System';

/**
 * - - - - - - - - - - - - - - -
 * Check folders & Define
 * - - - - - - - - - - - - - - -
 *
 */
define('IN_F_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('R_PATH', realpath($_root_path) . DIRECTORY_SEPARATOR);

if(is_dir( R_PATH . $_application_path)){

    define('A_PATH', $_application_path );

    if(is_dir( A_PATH . DIRECTORY_SEPARATOR .  $_configuration_path)){

        define('C_PATH', A_PATH . DIRECTORY_SEPARATOR . $_configuration_path );

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Configuration path is wrong!';
        exit(2);
    }

    if(is_dir( A_PATH . DIRECTORY_SEPARATOR .  $_framework_path)){

        define('FRAMEWORK_PATH', A_PATH . DIRECTORY_SEPARATOR . $_framework_path );

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Framework path is wrong!';
        exit(2);
    }

    if(is_dir( FRAMEWORK_PATH . DIRECTORY_SEPARATOR . $_framework_controllers_path)){

        define('FRAMEWORK_CONTROLLERS_PATH', FRAMEWORK_PATH . DIRECTORY_SEPARATOR . $_framework_controllers_path );

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Framework Controllers path is wrong!';
        exit(2);
    }

    if(is_dir( FRAMEWORK_PATH . DIRECTORY_SEPARATOR . $_framework_models_path)){

        define('FRAMEWORK_MODELS_PATH', FRAMEWORK_PATH . DIRECTORY_SEPARATOR . $_framework_models_path );

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Framework Models path is wrong!';
        exit(2);
    }

    if(is_dir( FRAMEWORK_PATH . DIRECTORY_SEPARATOR . $_framework_views_path)){

        define('FRAMEWORK_VIEWS_PATH', FRAMEWORK_PATH . DIRECTORY_SEPARATOR . $_framework_views_path );

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Framework Views path is wrong!';
        exit(2);
    }

    if(is_dir( A_PATH . DIRECTORY_SEPARATOR . $_libraries_path)){

        define('LIBRARIES_PATH', A_PATH . DIRECTORY_SEPARATOR . $_libraries_path );

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Libraries path is wrong!';
        exit(2);
    }

    if(is_dir( A_PATH . DIRECTORY_SEPARATOR . $_system_path)){

        define('SYSTEM_PATH', A_PATH . DIRECTORY_SEPARATOR . $_system_path );

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'System path is wrong!';
        exit(2);
    }

} else {
    header('HTTP/1.1 503 Service Unavailable', true, 503);
    echo 'Application path is wrong!';
    exit(2);
}

/**
 * - - - - - - - - - - - - - - -
 * Load bootstrap file
 * - - - - - - - - - - - - - - -
 *
 * Let's Go!
 *
 */

require_once R_PATH . A_PATH . DIRECTORY_SEPARATOR . 'Bootstrap.php';



