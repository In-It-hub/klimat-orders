<?php
    require MODEL.'CRUD.php';
    
    class Telegram extends Controller
    {
        public $crud;
        public $TOKEN;
        public $BASE_URL;
        public $update;
        public $message;
        public $chat_id;
        public $text;
        public function __construct()
        {
            $this->crud = new CRUD();
            $this->TOKEN = '2070946057:AAGF-YBpiPyt9oa4s9uS_SZmzBvE0bxWWx0';
            $this->BASE_URL = 'https://api.telegram.org/bot' . $this->TOKEN . '/';
            $this->update = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);
            $this->message = $this->update['message'];
            $this->chat_id = $this->message['chat']['id'];
            $this->text = $this->message['text'];
        }
        public function index() {
            $auth = FALSE;//Пользователь не авторизированый
            $login = '';
            /*$users_login = $this->crud->read('users');
            foreach ($users_login['entries'] as $user_login) {
                if($this->chat_id == $user_login["telegram_id"]) {
                    $login = $user_login["user_login"];
                }
            }*/
            $users =  $this->crud->listUsers();
            foreach ($users as $user) {
                if($this->chat_id == $user["telegram_id"]) {
                    $login = $user["user"];
                    if($user["auth_status"] === 'auth') {
                        $auth = TRUE; 
                    }
                }
            }
            switch ($this->text) {
                case '/start':
                    if ($auth) {
                        $this->bot();
                    }else {
                         $this->sendRequest('sendMessage', [
                             'chat_id' => $this->chat_id,
                             'text' => 'Введите логин!',
                         ]);
                    }
                    break;
                case $this->text !== '/start' && $auth == FALSE && empty($login):
                    foreach ($users as $user) {
                        if($this->text == $user["user"]) {
                            $data = ["user" =>[
                                '_id' => $user["_id"],
                                'telegram_id' => $this->chat_id
                            ]];
                            $save_users = $this->crud->saveUser($data);
                            $this->sendRequest('sendMessage', [
                                'chat_id' => $this->chat_id,
                                'text' => 'Отлично теперь пароль!',
                            ]);
                            
                        }
                    }
                    break;
                case $this->text !== '/start' && $auth == FALSE && !empty($login):
                    $data = [
                        'user' => $login,
                        'password' => $this->text,
                    ];
                    $autorization = $this->crud->authUser($data);
                    if(!empty($autorization->error)) {
                        $data = ["user" =>[
                            '_id' => $user["_id"],
                            'telegram_id' => 0,

                        ]];
                        $save_users = $this->crud->saveUser($data);
                        $this->sendRequest('sendMessage', [
                            'chat_id' => $this->chat_id,
                            'text' => 'Вы ввели неправильный логин или пароль',
                        ]);
                        $this->sendRequest('sendMessage', [
                            'chat_id' => $this->chat_id,
                            'text' => 'Введите логин!',
                        ]);
                    }
                    else {
                        
                        $data = ["user" =>[
                            '_id' => $autorization->_id,
                            'telegram_id' => $this->chat_id,
                            'auth_status' => 'auth'
                        ]];
                        $save_users = $this->crud->saveUser($data);
                        $this->bot();
                    }
                    break;
                default:
                    $this->sendRequest('sendMessage', [
                        'chat_id' => $this->chat_id,
                        'text' => 'Неизвестная команда!',
                    ]);
                    break;
            }
        }
        public function sendRequest($method, $params = []) {
            if (!empty($params)) {
                $url = $this->BASE_URL . $method . '?' . http_build_query($params);
            } else {
                $url = $this->BASE_URL . $method;
            }
            return json_decode(
                file_get_contents($url),
                JSON_OBJECT_AS_ARRAY
            );
        }

        public function bot()
        {
            $this->sendRequest('sendMessage', [
                'chat_id' => $this->chat_id,
                'text' => 'Добро Пожаловать'.$this->chat_id,
            ]);
        }
            /*if ($this->text) {
                $users = [
                    'table' => 'users',
                    'table_column' => '*'
                ];
                $user = $this->crud->read($users, 'telegram_id', $this->chat_id);
                if ($user) {
                    $this->sendRequest('sendMessage', [
                        'chat_id' => $this->chat_id,
                        'text' => 'Добро пожаловать',
                    ]);
                } else {
                    $this->sendRequest('sendMessage', [
                        'chat_id' => $this->chat_id,
                        'text' => 'Введите пароль:',
                    ]);
                    $this->login();
                }
            }*/

        /*public function login(){
            if(isset($this->text)&& $this->text !== '/start') {
                $users = [
                    'table' => 'users',
                    'table_column' => '*'
                ];
                $view_data['users'] = $this->crud->read($users, 'password', $this->text);
                if($view_data['users']) {
                    $data['id'] = $view_data['users']['id'];
                    $data['telegram_id'] = $this->chat_id;
                    $this->crud->update('users', $data);
                    $this->sendRequest('sendMessage', [
                        'chat_id' => $this->chat_id,
                        'text' => 'Найден',
                    ]);
                }
                else {
                    $this->sendRequest('sendMessage', [
                        'chat_id' => $this->chat_id,
                        'text' => 'Не Найден',
                    ]);
                }
            }
        }*/



        /*public function bot($chat_id){
            $reply_markup = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [
                        ['text' => "Заявки на сегодня"]
                    ]
                ]
            ]);
            $response = $this->sendRequest('sendMessage',[
                'chat_id' => $chat_id,
                'text' => 'Выберите заявки ',
                'parse_mode' => 'markdown',
                'reply_markup' => $reply_markup
            ]);
            if ($this->text == "Заявки на сегодня") {
                $data['columns'] = 'orders.id, 
                			orders.date,
                            orders.status_id, 
                			status.status_name,
                            status.color, 
                			orders.work_start_date, 
                			orders.time,
                            orders.city_id, 
                			city.name, 
                			orders.address, 
                			orders.working,
                			orders.phone,
                            orders.client,
                            orders.comment,
                            orders.execution,
                            orders.cash,
                            orders.user_id,
                            users.telegram_id';
                $data['table'] = ['orders', 'status', 'city', 'users'];
                $data['key'] = ['status_id', 'city_id', 'user_id'];
                $data['type'] = 'INNER';
                $view_data['orders'] = $this->crud->join($data,'users.telegram_id', $chat_id);
                $this->sendRequest('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => $view_data['orders'],
                ]);
            }
        }
        /*if (isset($this->text)) {
            typing($this->chat_id);
        }
        $send_message = $first_name . ' ' . $last_name . ' Отправил сообщение с текстом ' . $text;
        $chat_id = $update['message']['chat']['id'];
        //sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $send_message]);

        /*$button = json_encode([
            'resize_keyboard' => true,
            'keyboard' => [
                [['text' => "Покровск"], ['text' => "Райполе"]]
            ]
        ]);*/

        
        /*if ($text == "Райполе") {
            sendRequest('sendMessage', [
                'chat_id' => $chat_id,
                'text' => 'Погода в Райполе',
                'parse_mode' => 'markdown',
                'reply_markup' => $button
            ]);
        }*/
        /*$quotes[] = 'О великий Сашка, Славься во веки вечные.';
        $quotes[] = 'Сашка Повелитель сахарного тросника';
        $quotes[] = 'Саня лінива срака, але як захоче то зробить все';
        $quotes[] = 'Мудрий і розумний Якщо не спить то лежить';
        $quotes[] = 'Тищо ще не здох?';
        srand ((double) microtime() * 1000000);
        $random_number = rand(0,count($quotes)-1);

        /*if ($chat_id == 827202255) {
            sendRequest('sendMessage', [
                'chat_id' => $chat_id,
                'text' => 'А Я Умный бот Я знаю Что Сорока Это Кристина Ксенофонтова и она сейчас читает. Это сообщение отправляеться только ей. Ура Ура Ура',
                //'parse_mode' => 'markdown',
                //'reply_markup' => $button
            ]);
        }
        if (isset($text) && $text !== '/start') {
            sendRequest('sendMessage', [
                'chat_id' => $chat_id,
                'text' => $quotes[$random_number],
                //'parse_mode' => 'markdown',
                //'reply_markup' => $button
            ]);
        }*/
    }