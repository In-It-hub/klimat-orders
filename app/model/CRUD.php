<?php
/**
  * CREATE READ UPDATE DELETE
  */
class CRUD {

	public function read($collectionname, $filter = null, $token = null) {
        $url = COCKPIT . 'api/collections/get/' . $collectionname . '?token=';
        if($token) {
            $url .= $token;
        }else {
            $url .= $_SESSION['token'];
        }
        $ch = curl_init($url);
        if(isset($filter)) {
            $filter_string = json_encode($filter, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $filter_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($filter_string))
            );
        }
        else {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        return json_decode(curl_exec($ch), true);
	}

	/*Добавляет новые записи в таблицу*/
	public function  save($collectionname, $data) {
                $data_string = json_encode($data, true);
                $url = COCKPIT . 'api/collections/save/' . $collectionname . '?token=' . $_SESSION['token'];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                return curl_exec($ch);
        }
        //Удаляет записи из таблицы
        public function delete($collectionname, $filter) {
                $filter_string = json_encode($filter, true);
                $url = COCKPIT . 'api/collections/remove/' . $collectionname . '?token=' . $_SESSION['token'];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $filter_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($filter_string))
                );
                return curl_exec($ch);
        }

        public function listUsers()
        {
            $url = COCKPIT . 'api/cockpit/listUsers'. '?token='.COCKPIT_TOKEN;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ')
            );
            return json_decode(curl_exec($ch), true);
        }

        public function saveUser($data)
        {       $data_string = json_encode($data, true);
                $url = COCKPIT . 'api/cockpit/saveUser'. '?token='.COCKPIT_TOKEN;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                return curl_exec($ch);
        }

        public function authUser($data)
        {
                $data_string = json_encode($data);
                $url = COCKPIT . 'api/cockpit/authUser' . '?token='.COCKPIT_TOKEN;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                return json_decode(curl_exec($ch));
        }

 }

