<?php
    require MODEL.'CRUD.php';

    class Status extends Controller
    {
        public $crud;

        public function __construct()
        {
            $this->crud = new CRUD();
        }
           
        public function index() {
			$this->view('status\index');
            $this->view->render();  
        }
        //Считываем таблицу городов
        public function read() {
            $city = $this->crud->read('status');
            $view_data['status']['data'] = $city["entries"];
            echo json_encode($view_data['status'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        public function save()
        {
            if (empty($_POST['_id'])) {
                $data = ['data'=>[
                    'status_name' => $_POST['status_name'],
                    'color' => $_POST['color']
                ]];
            } else {
                $data = ['data'=>[
                    '_id' => $_POST['_id'],
                    'status_name' => $_POST['status_name'],
                    'color' => $_POST['color']
                ]];
            }
            echo $this->crud->save('status', $data);
        }
    }