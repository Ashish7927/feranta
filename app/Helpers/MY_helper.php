<?php



if(!function_exists('chicking_helper')) {
    function chicking_helper(){
        return 'welcome to helper function';
    }
}


if (!function_exists('siteinfo')) {

    function siteinfo()
    {
        $db = db_connect();
        $data['setting'] = $db->query("SELECT * FROM `settingg` WHERE `settingg_id` = 1")->getResult();
        $session = session();
        $user_id =$session->get('user_id');
        $data['singleuser'] = $db->query("SELECT * FROM `user` where `id` = ".$user_id)->getResult();
        return $data;
    }
}






