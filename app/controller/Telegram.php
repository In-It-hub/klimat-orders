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
            $this->TOKEN = TELEGRAM_TOKEN;
            $this->BASE_URL = 'https://api.telegram.org/bot' . $this->TOKEN . '/';
            $this->update = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);
            $this->message = $this->update['message'];
            $this->chat_id = $this->message['chat']['id'];
            $this->text = $this->message['text'];
        }
        public function index() {
            $auth = FALSE;//Пользователь не авторизированый
            $login = '';//Логин пользователя (Если логин  был введен правильно)
            $users =  $this->crud->listUsers();
            foreach ($users as $user) {
                if($this->chat_id == $user["telegram_id"]) {
                    $login = $user["user"];
                    if(!empty($user["auth_status"])) {
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
                        foreach ($users as $user) {
                            if($user["user"] = $login) {
                                $data = ["user" => [
                                    '_id' => $user["_id"],
                                    'telegram_id' => 0,
                                ]];
                                $save_users = $this->crud->saveUser($data);
                            }
                        }
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
                            'auth_status' => $autorization->api_key
                        ]];
                        $save_users = $this->crud->saveUser($data);
                        $this->bot();
                    }
                    break;
                case "Заказы на завтра" && $auth == TRUE:
                    $orders = [];
                    foreach ($users as $user) {
                        if($this->chat_id == $user["telegram_id"]) {
                            $filter = ['filter'=>[
                                "_id" => "e57fc0b23234346e7f00012e"
                            ]];
                            $orders = $this->crud->read('orders', $filter, $user["auth_status"]);
                        }
                    }

                    print_r($orders["entries"]);
                    $this->sendRequest('sendMessage', [
                        'chat_id' => $this->chat_id,
                        'text' => "Все заказы на завтра " . $orders["entries"][0]['address'],
                    ]);
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
            $replyMarkup = [
                'resize_keyboard' => true,
                'keyboard' => [
                    ["Заказы на завтра"]
                ]
            ];
            $encodedMarkup = json_encode($replyMarkup);
            $this->sendRequest('sendMessage', [
                'chat_id' => $this->chat_id,
                'text' => 'Добро Пожаловать' . $this->chat_id,
                'reply_markup' => $encodedMarkup
            ]);

        }
    }