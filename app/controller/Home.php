<?php
require MODEL.'CRUD.php';
class Home extends Controller {
    
    public $crud;

    public function __construct($id='', $name='') {
        $this->crud = new CRUD();
        //echo 'Мы в классе ' . __CLASS__, ' Метод ' . __METHOD__ .'Параметры'. $id. $name;
        //echo 'Id:is ' . $id . ' name ' . $name;
    	
        $this->view('home\index', ['id' => $id, 'name' => $name]);
        $this->view->render();
    }

}