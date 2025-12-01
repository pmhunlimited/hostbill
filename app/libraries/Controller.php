<?php
  /*
   * Base Controller
   * Loads the models and views
   */
  class Controller {
    // Load model
    public function model($model){
      // Require model file
      require_once dirname(__DIR__) . '/models/' . $model . '.php';

      // Instatiate model
      return new $model();
    }

    // Load view
    public function view($view, $data = []){
      // Check for view file
      if(file_exists(dirname(__DIR__) . '/views/' . $view . '.php')){
        require_once dirname(__DIR__) . '/views/' . $view . '.php';
      } else {
        // View does not exist
        die('View does not exist');
      }
    }
  }
