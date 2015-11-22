<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 11/09/2015 Time: 15:00
 */

defined('R_PATH') OR exit('No Direct Script');

class APP_Controller {

    private static $classes;

    var $Loader;

    public function __construct(){

        self::$classes =& $this;
        foreach (is_class_loaded() as $var => $class)
        {
            $this->$var =& _load_class($class);
        }
        $this->Load =& _load_class('Loader', 'System', '', '', 'FT_Loader');

    }

    public static function &get_classes()
    {
        return self::$classes;
    }

}