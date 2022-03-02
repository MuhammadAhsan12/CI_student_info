<?php
class User_model extends CI_Model {
    public function ShowloginForm()
    {
        $html = $this->load->view('loginForm','',true);
        $response['html'] = $html;
        echo json_encode($response);
    }
}