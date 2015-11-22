<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 09/09/2015 Time: 12:14
 */

class FT_Router{

    public $base_path;
    public $web_settings;
    public static $url_found;

    function __construct($base_path = '/'){
        defined('BASE_PATH_URL') ? $this->base_path = BASE_PATH_URL : $this->base_path = $base_path;
        $this->url_found = $this->Get_URL();
        $this->web_settings = unserialize( WEB_SETTINGS );
    }

    function Get_URL($return = true){

        header('Cache-Control: no-cache');
        header('Pragma: no-cache');
        header("Access-Control-Allow-Origin: *");

        $url_complete = explode('/', $_SERVER['REQUEST_URI']);
        $script_complete = explode('/', $_SERVER['SCRIPT_NAME']);

        for($i = 0; $i < count($script_complete);){
            if (@$url_complete[$i] == @$script_complete[$i]){
                unset($url_complete[$i]);
            }
            $i++;
        }

        @$url_value = array_values($url_complete);

        if(!empty($this->web_settings['first_controller_class'])){
            $url_value[0] = ((isset($url_value[0])) && ($url_value[0] != '')) ? $url_value[0] : $this->web_settings['first_controller_class'];
        }


        for($i_count = 1; $i_count <= count($url_value); $i_count++){

            if(@strpos($url_value[ $i_count ], "?")  !== false ) {
                @$url_get_value = explode("?", $url_value[ $i_count ]);
                $url_value[ $i_count ] = $url_get_value[0];
                unset($url_get_value[0]);
                array_splice( $url_value, $i_count + 1, 0, $url_get_value );
                //@$url_value[] = implode("&", $url_get_value);
            }
        }


        if($return == true){
            return $url_value;
        }

    }

    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

}