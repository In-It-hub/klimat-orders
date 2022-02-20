<?php
    require MODEL.'CRUD.php';
    
    class Orders extends Controller
    {
        public $crud;
        public $status;
        
        public function __construct()
        {
           $this->crud = new CRUD();
        }
           
        public function index() {
			$this->view('orders\index');
            $this->view->render();  
        }

        //Считываем таблицу заказов
        public function read() {
            $orders = $this->crud->read('orders');
            $view_data['data'] = $orders["entries"];
            $view_data['status'] = $this->crud->read('status')["entries"];
            $this->status = $view_data['status'];
            //считываем пользователей
            //$view_data['users'] = $this->crud->read('users')["entries"];
           echo json_encode($view_data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }


        public function save()
        {
            $status_filter = ["filter" => [
               "_id" =>  $_POST['status']
            ]];
            $city_filter = ["filter" => [
                "_id" => $_POST['city']
            ]];
            $city =  $this->crud->read('city', $city_filter)["entries"][0];
            $this->status = $this->crud->read('status', $status_filter)["entries"][0];
            $data = ['data'=>[
                'date' => $_POST['date'],
                'status' => [
                    '_id' => $_POST['status'],
                    'link' => 'status',
                    'display' => $this->status['status_name'],
                    'color' => $this->status['color']
                ],
                'work_start_date' => $_POST['work_start_date'],
                'time' => $_POST['time'],
                'city' => [
                    '_id' => $_POST['city'],
                    'link' => 'city',
                    'display' => $city["city_name"]
                ],
                'address' => $_POST['address'],
                'working' => $_POST['working'],
                'phone' => $_POST['phone'],
                'client' => $_POST['client'],
                'comment' => $_POST['comment'],
                'execution' => $_POST['execution'],
                'cash' => $_POST['cash']
            ]];
            if (!empty($_POST['_id'])) {
                $data['data'] += ['_id' => $_POST['_id']];
                $data['data'] = array_reverse($data['data'], false);
            }
            echo $this->crud->save('orders', $data);
        }

    }