<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 25/07/2017
 * Time: 11:10
 */
class template_controller
{
    public function get_list_template( ){
        require_once "../dao/class.template_dao.php";
        $template_dao = new template_dao();
        $template = $template_dao->get_list_template( );
        return $template;
    }

    public function get_template($codigo){
        require_once "../dao/class.template_dao.php";
        $template_dao = new template_dao();
        $template = $template_dao->get_template($codigo);
        return $template;
    }

    public function insert_template( template $template ){
        require_once "../dao/class.template_dao.php";
        $template_dao = new template_dao();
        $template = $template_dao->insert_template($template);
        return $template;
    }

    public function update_template( template $template ){
        require_once "../dao/class.template_dao.php";
        $template_dao = new template_dao();
        $template = $template_dao->update_template($template);
        return $template;
    }

    public function delete_template( $template ){
        require_once "../dao/class.template_dao.php";
        $template_dao = new template_dao();
        $template = $template_dao->delete_template($template);
        return $template;
    }
}