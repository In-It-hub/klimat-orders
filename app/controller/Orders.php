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
            $view_data['orders']['data'] = $orders["entries"];
            //https://example.com/api/cockpit/listUsers?token=xxtokenxx&filter[_id]=user_id
            echo json_encode($view_data['orders'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        public function read_city_status_users() {
            //считываем города
			$view_data['city'] = $this->crud->read('city')["entries"];
            //считываем статусы
			$view_data['status'] = $this->crud->read('status')["entries"];
            $this->status = $view_data['status'];
            //считываем пользователей
			$view_data['users'] = $this->crud->read('users')["entries"];
            echo json_encode($view_data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        public function save()
        {
            $this->status = $this->crud->read('status')["entries"];
            foreach ($this->status as $status) {
                if($status['_id'] == $_POST['status']){
                    $status_display = $status['status_name'];
                    $status_color = $status['color'];
                    
                }
            }
            if (empty($_POST['_id'])) {
                $data = ['data'=>[
                    'date' => $_POST['date'],
                    'status' => [
                        '_id' => $_POST['status'], 
                        'link' => 'status',
                        'display' => $status_display,
                        'color' => $status_color
                    ],
                    'work_start_date' => $_POST['work_start_date'],
                    'time' => $_POST['time'],
                    'city' => [
                        '_id' => $_POST['city'], 
                        'link' => 'city',
                        'display' => $this->crud->read('city', $_POST['city'])["entries"][0]['city_name']
                    ],
                    'address' => $_POST['address'],
                    'working' => $_POST['working'],
                    'phone' => $_POST['phone'],
                    'client' => $_POST['client'],
                    'comment' => $_POST['comment'],
                    'execution' => $_POST['execution'],
                    'cash' => $_POST['cash']
                ]];
            } else {
                $data = ['data'=>[
                    '_id' => $_POST['_id'],
                    'date' => $_POST['date'],
                    'status' => [
                        '_id' => $_POST['status'], 
                        'link' => 'status',
                        'display' => $status_display,
                        'color' => $status_color
                    ],
                    'work_start_date' => $_POST['work_start_date'],
                    'time' => $_POST['time'],
                    'city' => [
                        '_id' => $_POST['city'], 
                        'link' => 'city',
                        'display' => $this->crud->read('city', $_POST['city'])["entries"][0]['city_name']
                    ],
                    'address' => $_POST['address'],
                    'working' => $_POST['working'],
                    'phone' => $_POST['phone'],
                    'client' => $_POST['client'],
                    'comment' => $_POST['comment'],
                    'execution' => $_POST['execution'],
                    'cash' => $_POST['cash']
                ]];
                
            }
            echo $this->crud->save('orders', $data);
        }

    }