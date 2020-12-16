<?php


namespace app\components;

class Pagesize 
{
    public static function init($sizes, $get)
    {   
        $label = "<label class='col mt-1' style='padding-right: 0px; color:blue'>List View</label>";
        $form = "<form class='row' style='width: 200px' id='psForm'>".$label."<select name='pageSize' class='col form-control'  id='psInput'>";
        foreach ($sizes as $v) {
            $selected =  isset($get['pageSize']) && $get['pageSize']==$v;
            $form .= $selected ?  "<option selected>".$v."</option>" : "<option>".$v."</option>";
        }
        $form .= "</select></form>";
        return  $form;
    }
}