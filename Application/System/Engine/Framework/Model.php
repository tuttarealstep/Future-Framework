<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 12/09/2015 Time: 01:25
 */

defined('R_PATH') OR exit('No Direct Script');

class APP_Model{

    public function __construct()
    {

    }

    public function __get($Obj)
    {
        return get_classes()->$Obj;
    }

}