<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 11/09/2015 Time: 15:00
 */

defined('R_PATH') OR exit('No Direct Script');

class FT_Loader {

    protected $_ob_get_level;
    protected $_classes;
    protected $_models = [];
    protected $_cached_vars = [];

    public function __construct()
    {
        $this->_ob_get_level = ob_get_level();
        $this->_classes =& is_class_loaded();
    }

    public function Database($return = false){
        $Future =& get_classes();

        require_once( SYSTEM_PATH . DIRECTORY_SEPARATOR . '/Engine/Database/Database.php' );

        $connection_info = unserialize ( CONNECTION_SETTINGS );

        if($connection_info['database_enabled'] == true)
        {
            if($return === true) {
                return Database_Initialize($connection_info['database_driver']);
            } else {
                $Future->Database = '';
                $Future->Database =& Database_Initialize($connection_info['database_driver']);
                return $this;
            }
        }

    }

    public function _is_loaded($class_name){
        return array_search($class_name, $this->_classes, TRUE);
    }

    /*public function _library($libray, $custom_name = null){
        if (is_array($libray))
        {
            foreach ($libray as $libray_obj => $value)
            {
                if($value != ''){
                    $this->_library($libray_obj, $value);
                } else {
                    $this->_library($libray_obj);
                }
            }
            return $this;
        }
        elseif (empty($library))
        {
            return false;
        }
        $Future =& get_classes();
        if($custom_name != ''){
            if(isset($Future->$custom_name)){
                header('HTTP/1.1 503 Service Unavailable', true, 503);
                echo 'A object with the same name was found!';
                exit(2);
            }
        } else {
            if(isset($Future->$libray)){
                header('HTTP/1.1 503 Service Unavailable', true, 503);
                echo 'A object with the same name was found!';
                exit(2);
            }
        }
        return $this;
    }*/

    public function _model($model_name, $custom_name = null, $custom_is_class = false){

        if (is_array($model_name))
        {
            foreach ($model_name as $key => $value)
            {
                is_int($key) ? $this->_model($value, '') : $this->_model($key, $value);
            }
            return $this;
        }
        elseif (empty($model_name))
        {
            return false;
        }

        if(empty($custom_name)) {
            $obj_name = $model_name;
        } else {
            $obj_name = $custom_name;
        }

        if (in_array($obj_name, $this->_models, TRUE))
        {
            return $this;
        }

        $Future =& get_classes();

        if(isset($Future->$obj_name)){
            header('HTTP/1.1 503 Service Unavailable', true, 503);
            echo 'A object with the same name was found!';
            exit(2);
        }

        if (!class_exists('APP_Model', FALSE))
        {
            _load_class('Model', 'System/Engine/Framework', null, '', 'APP_Model');
        }

        if ( ! class_exists( $model_name ))
        {
            if ( ! file_exists( FRAMEWORK_MODELS_PATH . DIRECTORY_SEPARATOR . $model_name . '.php'))
            {
                header('HTTP/1.1 503 Service Unavailable', true, 503);
                echo 'Model not found!';
                exit(2);
            }
            require_once(FRAMEWORK_MODELS_PATH . DIRECTORY_SEPARATOR . $model_name . '.php');
        }
        $this->_models[] = $obj_name;
        if($custom_is_class === true){
            $Future->$obj_name = new $obj_name();
        } else {
            $Future->$obj_name = new $model_name();
        }
        return $this;

    }

    public function Load_Debug_Bar(){

        if(FUTURE_MODE == 'development')
        {
            $variable_bar = "Memory Usage: " . memory_get_usage() . " (" . ((memory_get_usage() / 1024) / 1024) . " M)" . " | Memory limit: " . ini_get('memory_limit');

            $info =  "<style>
                       .debug_bar{
                            line-height: 3;
                            padding-left: 10px;
                            padding-right: 10px;
                            position: fixed;
                            bottom: 10px;
                            width: auto;
                            height: 50px;
                            background-color: #008EFF;
                            border: 2px solid #004E8B;
                            border-radius: 8px;
                            box-shadow: 3px 3px 5px #888888;
                            color: #fff;
                            margin-left: 10px;
                            font-family: 'Times New Roman', Georgia, Serif;
                       }
                    </style>
                    <div class='debug_bar'>$variable_bar</div>";
            EOD;
            return $info;
        }

    }

    public function _view($view_file, $data = null, $return = false){

        if (is_array($view_file))
        {
            foreach ($view_file as $key => $value)
            {
                if(!empty($value)){
                    $this->_view($key, $value);
                } else {
                    $this->_view($key, $value);
                }
            }
            return $this;
        }
        elseif (empty($view_file))
        {
            return false;
        }

        $Future =& get_classes();
        foreach (get_object_vars($Future) as $_key => $_var)
        {
            if ( ! isset($this->$_key))
            {
                $this->$_key =& $Future->$_key;
            }
        }

        if ( ! file_exists( FRAMEWORK_VIEWS_PATH . DIRECTORY_SEPARATOR . $view_file . '.php'))
        {
            header('HTTP/1.1 503 Service Unavailable', true, 503);
            echo 'View File not found!';
            exit(2);
        }

        $data = $this->object_to_array($data);

        if (is_array($data))
        {
            $this->_cached_vars = array_merge($this->_cached_vars, $data);
        }
        extract($this->_cached_vars);

        ob_start();

        include(FRAMEWORK_VIEWS_PATH . DIRECTORY_SEPARATOR . $view_file . '.php');

        $content = ob_get_contents();

        //TAGS
        $content = str_ireplace('{@memory_usage@}', memory_get_usage(), $content);
        $content = str_ireplace('{@debug_bar@}', $this->Load_Debug_Bar(), $content);

        if ($return === true)
        {
            @ob_end_clean();
            return $content;
        }

        if (ob_get_level() > $this->_ob_get_level + 1)
        {
            ob_end_flush();
        }
        else
        {
            $Future->View->ADD_Output($content);
            @ob_end_clean();
        }

        return $this;
    }

    public function _view_template($view_template_file, $data = null, $return = false){

        if (is_array($view_template_file))
        {
            foreach ($view_template_file as $key => $value)
            {
                if(!empty($value)){
                    $this->_view_template($key, $value);
                } else {
                    $this->_view_template($key, $value);
                }
            }
            return $this;
        }
        elseif (empty($view_template_file))
        {
            return false;
        }

        $Future =& get_classes();
        foreach (get_object_vars($Future) as $_key => $_var)
        {
            if ( ! isset($this->$_key))
            {
                $this->$_key =& $Future->$_key;
            }
        }

        if ( ! file_exists( A_PATH . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . $view_template_file . '.php'))
        {
            header('HTTP/1.1 503 Service Unavailable', true, 503);
            echo 'Template File not found!';
            exit(2);
        }

        $data = $this->object_to_array($data);

        if (is_array($data))
        {
            $this->_cached_vars = array_merge($this->_cached_vars, $data);
        }
        extract($this->_cached_vars);

        ob_start();

        include( A_PATH . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . $view_template_file . '.php');

        $content = ob_get_contents();

        //TAGS
        $content = str_ireplace('{@memory_usage@}', memory_get_usage(), $content);
        $content = str_ireplace('{@debug_bar@}', $this->Load_Debug_Bar(), $content);

        if ($return === true)
        {
            @ob_end_clean();
            return $content;
        }

        if (ob_get_level() > $this->_ob_get_level + 1)
        {
            ob_end_flush();
        }
        else
        {
            $Future->View->ADD_Output($content);
            @ob_end_clean();
        }

        return $this;
    }

    protected function object_to_array($object)
    {
        return is_object($object) ? get_object_vars($object) : $object;
    }

}