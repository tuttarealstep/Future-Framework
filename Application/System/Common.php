<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 09/09/2015 Time: 11:03
 */

defined('R_PATH') OR exit('No Direct Script');

/**
 * - - - - - - - - - - - - - - -
 * Load class function
 * - - - - - - - - - - - - - - -
 *
 */
/**
 * @param $class_name
 * @param string $directory
 * @param null $class_param
 * @param string $prefix
 * @param string $custom_name
 * @return mixed
 */
function &_load_class($class_name, $directory = 'Libraries', $class_param = null, $prefix = 'FT_', $custom_name = ''){

    static $_classes_array = [];

    if($custom_name != '' && isset($_classes_array[$custom_name])){
        return $_classes_array[$custom_name];
    }

    if(isset($_classes_array[$class_name])){
        return $_classes_array[$class_name];
    }

    if( file_exists( A_PATH . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $prefix . $class_name . '.php') ) {

        if (class_exists($prefix . $class_name, FALSE) === FALSE)
        {
            require_once(A_PATH . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $prefix . $class_name . '.php');
        } elseif (class_exists($prefix . $custom_name, FALSE) === FALSE && $custom_name != '') {
            require_once(A_PATH . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $prefix . $class_name . '.php');
        }

        if($custom_name != ''){
            $class_prefix_name = $prefix . $custom_name;
        } else {
            $class_prefix_name = $prefix . $class_name;
        }


        is_class_loaded($class_name);
        $_classes_array[$class_name] = isset($class_param) ? new $class_prefix_name($class_param) : new $class_prefix_name();
        return $_classes_array[$class_name];

    } else {
        header('HTTP/1.1 503 Service Unavailable', true, 503);
        echo 'Unable to locate the class: ' . $prefix . $class_name . '.php';
        exit;
    }
}

/**
 * @param string $class_name
 * @return mixed
 */
function &is_class_loaded($class_name = ''){

    static $_is_class_loaded = array();
    if ($class_name !== '')
    {
        $_is_class_loaded[$class_name] = $class_name;
    }
    return $_is_class_loaded;

}