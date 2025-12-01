<?php
class Pages extends Controller {
    public function __construct() {
        // You can load models here if needed
    }

    public function index() {
        $data = [
            'title' => SITENAME,
            'description' => 'Welcome to the VTU platform'
        ];
        $this->view('pages/index', $data);
    }
}
