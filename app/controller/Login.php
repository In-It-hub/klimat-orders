<?php 

	/**
		 * Login
		 */

	class Login extends Controller
	{
        protected $view_data = [];
        function __construct()
		{

		}

		public function index()
        {
            if (!empty($_POST['submit'])) {
                $fields = [
                    'user' => $_POST['login'],
                    'password' => $_POST['password'],
                ];
                $data_string = json_encode($fields);
                $url = COCKPIT . 'api/cockpit/authUser' . '?token=75654c11418a68626f30a88b74a51b';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                $auth = json_decode(curl_exec($ch), true);
                if (isset($auth['error'])) {
                    $this->view_data['message'] = '<div class="box has-background-danger">Логин или пароль введены не правильно!!</div>';
                } else {
                    $_SESSION['group'] = $auth['group'];
                    $_SESSION['user'] = $auth['user'];
                    $_SESSION['token'] = $auth['api_key'];
                    header('Location:home');
                }
            }
            $this->view('login', $this->view_data);
            $this->view->render();
		}
	}	
