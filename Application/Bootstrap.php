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

defined('R_PATH') OR exit('No Direct Script');

define('FUTURE_VERSION', '00.1');

/**
 * - - - - - - - - - - - - - - -
 * Load configuration path
 * - - - - - - - - - - - - - - -
 *
 */
if(file_exists(C_PATH . DIRECTORY_SEPARATOR . 'Config.php')){
    require_once( C_PATH . DIRECTORY_SEPARATOR . 'Config.php' );
} else {
    header('HTTP/1.1 503 Service Unavailable', true, 503);
    echo 'Configuration file not found!';
    exit(2);
}

defined( 'CONNECTION_SETTINGS' ) || define( 'CONNECTION_SETTINGS' , serialize( $connection_settings ) );
defined( 'WEB_SETTINGS' ) || define( 'WEB_SETTINGS' , serialize( $web_settings ) );

/**
 * - - - - - - - - - - - - - - -
 * Load common file with global
 * functions
 * - - - - - - - - - - - - - - -
 *
 */
if(file_exists(SYSTEM_PATH . DIRECTORY_SEPARATOR . 'Common.php')){
    require_once( SYSTEM_PATH . DIRECTORY_SEPARATOR . 'Common.php' );
} else {
    header('HTTP/1.1 503 Service Unavailable', true, 503);
    echo 'Common file not found!';
    exit(2);
}


//$Database =& _load_class('Database', 'Libraries/Connection');
$Router =& _load_class('Router', 'System/Engine/Router');

/**
 * - - - - - - - - - - - - - - -
 * Load Controller Class
 * for load all
 * - - - - - - - - - - - - - - -
 *
 */
if(file_exists(SYSTEM_PATH . DIRECTORY_SEPARATOR . 'Engine/Framework/Controller.php')){
    require_once( SYSTEM_PATH . DIRECTORY_SEPARATOR . 'Engine/Framework/Controller.php' );
} else {
    header('HTTP/1.1 503 Service Unavailable', true, 503);
    echo 'Controller file not found!';
    exit(2);
}

function &get_classes()
{
    return APP_Controller::get_classes();
}

/**
 * - - - - - - - - - - - - - - -
 * Get Router Info
 * - - - - - - - - - - - - - - -
 *
 */
$_router_path = FRAMEWORK_CONTROLLERS_PATH;
$_router_url = $Router->Get_URL();

$Array_count = count($_router_url) - 1;
$find_path = $_router_path . DIRECTORY_SEPARATOR;
$array = [];


for($i = 0; $i <= $Array_count; $i++) {
    if (is_dir( $find_path . $_router_url[$i])) {
        $find_path = $find_path . $_router_url[$i] . '/';
    } else {
        if (is_file( $find_path . $_router_url[$i] . '.php')) {
            if ($i < $Array_count) {
                for ($i_a = $i; $i_a <= $Array_count; $i_a++){
                    array_push($array, $_router_url[$i_a]);
                }
                unset($array[0]);
                $Request_Param = serialize($array);
            }
            include( $find_path . str_replace('/', '\\', $_router_url[$i]).'.php');
            $Request_Data =  str_replace('/', '\\', $_router_url[$i]);
            break;
        }
    }
}

/**
 * - - - - - - - - - - - - - - -
 * Load View For Output
 * - - - - - - - - - - - - - - -
 *
 */
$View =& _load_class('View', 'System/Engine/Framework', '', '', '');

if( ! isset ($Request_Param) || empty($Request_Param)){
    if(empty($_router_url)){
        SET_404();
    } else {
        if(class_exists($_router_url[0])){
            $Load_Controller = new $_router_url[0];
        } else {
           SET_404();
        }
    }
} else {
    $Request_Param = unserialize($Request_Param);
    if (count($Request_Param) <= 1) {
        $Request_Function = $Request_Param;
    } else {
        $Request_Function = $Request_Param[1];
        unset($Request_Param[1]);

        if (count($Request_Param)  >= 2) {
            $count = count($Request_Param) + 1;
            $count_l = 2;
            foreach($Request_Param as $key => $value){
                $Request_Param[$count_l - 1] = $value;
                unset($Request_Param[$count_l]);
                $count_l++;
            }

           // print_r($Request_Param);
            $count = 1;
            foreach($Request_Param as $key => $value){
                if(isset($Request_Param[$count + 1]) && $Request_Param[$count + 1] != ''){
                    $next = $Request_Param[$count + 1];
                    $Request_Param[$value] = $next;
                }

                unset($Request_Param[$key]);
                $count++;
            }


            /* //print_r($Request_Param);
             $count = 1;
             for($i_p = 1; $i_p <= count($Request_Param); $i_p++){
                 $value = $Request_Param[$count];
                 if(isset($Request_Param[$count + 1]) && $Request_Param[$count + 1] != ''){
                     $next = $Request_Param[$count + 1];
                     $Request_Param[$value] = $next;
                 }
                 unset($Request_Param[$count]);
                 $count++;
             }


             //unset($Request_Param[count($Request_Param) + 1]);
             /*for($i_parm = 2; $i < count($Request_Param) + 1; $i++){
                 $Request_Param[$i_parm] =  $Request_Param[$i_parm + 1];
             }*/
           //print_r($Request_Param);
        }

       /* if (count($Request_Param) >= 2) {
           $Request_Param[1] = $Request_Param[2];
            unset($Request_Param[2]);
            for ($i = 4; $i < count($Request_Param); $i++) {
                unset($Request_Param[$i]);
                $Request_Param[$i] = $Request_Param[$i + 1];
                if (count($Request_Param) == $i + 1) {
                    unset($Request_Param[$i + 1]);
                }
            }
        }*/

    }

    try {
        if (!empty($Request_Data)):
            $Load_Controller = new $Request_Data();
            if (!empty($Request_Param)) {
                if(is_array($Request_Function)){
                    foreach($Request_Function as $key => $value){
                        if(is_int($key)){
                            if(method_exists($Load_Controller, $value)){
                                $Load_Controller->$value($Request_Param);
                            } else {
                                SET_404();
                            }
                        }
                    }
                } else {
                    if(method_exists($Load_Controller, $Request_Function)){
                        $Load_Controller->$Request_Function($Request_Param);
                    } else {
                        SET_404();
                    }
                }
            } else {
                if(method_exists($Load_Controller, $Request_Function)){
                    $Load_Controller->$Request_Function();
                } else {
                    SET_404();
                }
            }
        endif;
    } catch (Exception $e) {
        echo $e;
        SET_404();
    }
}

function SET_404(){
    die("404 Error");
}

//$Test = new News();
//$Test->show();

echo $View->GET_OUTPUT();
//$Controller->Load->_model("test");
//var_dump($Controller);
//echo "<br>Caricato!";