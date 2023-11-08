<?php
require_once("model.php");
require_once("view.php");

class tdw_controller
{
    public function show_website()
    {
        $v = new tdw_view();
        $v->show_website();
    }
    public function get_smartphone_table()
    {
        $tdwm = new tdw_model();
        $result = $tdwm->get_smartphone_table_data();
        return $result;
    }
}
