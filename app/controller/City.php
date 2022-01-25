<?php
    require MODEL.'CRUD.php';
    
    class City extends Controller
    {
        public $crud;
        
        public function __construct()
        {
           $this->crud = new CRUD();
        }
           
        public function index() {
			$this->view('city\index');
            $this->view->render();  
        }

        //Считываем таблицу городов
        public function read() {
            $city = $this->crud->read('city');
            $view_data['city']['data'] = $city["entries"];
            echo json_encode($view_data['city'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        public function save()
        {
            if (empty($_POST['_id'])) {
                $data = ['data'=>[
                    'city_name' => $_POST['city_name'],
                ]];
            } else {
                $data = ['data'=>[
                    '_id' => $_POST['_id'],
                    'city_name' => $_POST['city_name']
                ]];
            }
            echo $this->crud->save('city', $data);
        }
    }