<?php
    require MODEL.'CRUD.php';
    
    class Users extends Controller
    {
        public $crud;
        
        public function __construct()
        {
           $this->crud = new CRUD();
        }
           
        public function index() {
			$this->view('users\index');
            $this->view->render();  
        }
        //Считываем таблицу статусов
        public function read() {
            $users = $this->crud->read('users');
            $url = COCKPIT . 'api/cockpit/listUsers'. '?token=75654c11418a68626f30a88b74a51b';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ')
                );
            $users_list = json_decode(curl_exec($ch), true);
            $view_data['users']['data'] = $users["entries"];
            foreach ($view_data['users']['data'] as $key => $view_user) {
                foreach ($users_list as $user) {
                   if($view_user['_id'] = $user['_id']){
                    $view_data['users']['data'][$key]['group'] = $user['group'];
                    break;
                   }
                }
            }
            
            //https://example.com/api/cockpit/listUsers?token=xxtokenxx&filter[_id]=user_id
            echo json_encode($view_data['users'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        //Добавляем новыый статус
        public function add() { 
                $data['id']; 
                $data['name'] = $_POST['name'];
                $data['login'] = $_POST['login'];
                $data['password'] = $_POST['password'];
                $data['telegram_id'] = $_POST['telegram_id'];
                $create = $this->crud->create('users', $data);
                echo json_encode($create, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        /* РЕДАКТИРОВАНИЕ СТАТУСА*/
        public function edit() {
            print_r($_POST);
                $data['id'] = $_POST['id']; 
                $data['name'] = $_POST['name'];
                $data['login'] = $_POST['login'];
                $data['password'] = $_POST['password'];
                $data['telegram_id'] = $_POST['telegram_id'];
                $update = $this->crud->update('users', $data);
                echo json_encode($update, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }

        public function delete($value) {
            if (!empty($_POST['delete'])) {
                $delete = $this->crud->delete('orders','id',$value);
                if (!empty($delete)){
                    echo "Запись Удалена";
                }
            }
            $this->view('orders\delete');
            $this->view->render();
        }
    }