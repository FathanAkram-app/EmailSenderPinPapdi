<?php

    require 'vendor/autoload.php';
    use Carbon\Carbon;

    

    class EmailHandler 
    {
        private $time;
        private $generated_token;

        function __construct(){
            $this->time = strval(floor(DateTime::createFromFormat('U.u', microtime(true))->format('U.u')));;
            $this->generated_token = hash_hmac("sha256","drdigitalindonesia"."::"."lEuPWDGLSnZcBCH9qprhXYRdw1NIFv8odrdigitalindonesia"."::".$this->time,"lEuPWDGLSnZcBCH9qprhXYRdw1NIFv8odrdigitalindonesia");
        }
        
        public function sendEmail()
        {
            
            

        }

        public function getList()
        {
            $curl = curl_init();

            
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kirim.email/v3/list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Auth-Id: drdigitalindonesia',
                'Auth-Token: '.$this->generated_token,
                'Timestamp: '.$this->time
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
            return json_decode($response,true);
        }

        public function createList($name)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kirim.email/v3/list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'name='.str_replace(" ", "%20",$name),
            CURLOPT_HTTPHEADER => array(
                'Auth-Id: drdigitalindonesia',
                'Auth-Token: '.$this->generated_token,
                'Timestamp: '.$this->time,
                'Content-Type: application/x-www-form-urlencoded'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }

        public function addSubscriber($listId, $fullname, $email, $nohp)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kirim.email/v3/subscriber/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'lists='
                .$listId
                .'&full_name='
                .$fullname
                .'&email='
                .str_replace("@","%40",$email)
                .'&fields%5Bno_hp%5D=%2B'
                .$nohp
                .'&fields%5Balamat%5D=Indonesia&tags=new%20tag%2C%20test%20tag',
            CURLOPT_HTTPHEADER => array(
                'Auth-Id: drdigitalindonesia',
                'Auth-Token: '.$this->generated_token,
                'Timestamp: '.$this->time,
                'Content-Type: application/x-www-form-urlencoded'
            ),
            ));

            $response = curl_exec($curl);

            
        }

        public function getSubscribers($name)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kirim.email/v3/subscriber/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array('name' => $name),
            CURLOPT_HTTPHEADER => array(
                'Auth-Id: drdigitalindonesia',
                'Auth-Token: '.$this->generated_token,
                'Timestamp: '.$this->time
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response,true);
        }
    }
    
    

?>