<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 12/09/2015 Time: 12:51
 */

defined('R_PATH') OR exit('No Direct Script');

class View{

    public $Output;

    public function GET_Output(){
        return $this->Output;
    }

    public function SET_Output($Output){
        $this->Output = $Output;
        return $this;
    }

    public function ADD_Output($Output){
        $this->Output .= $Output;
        return $this;
    }

    public function SET_CONTENT_TYPE($Content_type){
        header("Content-Type: $Content_type");
    }

}