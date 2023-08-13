<?php

class Games {
    private $api_url;
    private $api_key;

    public function __construct($api_url, $api_key) {
        $this->api_url = $api_url;
        $this->api_key = $api_key;
    }

    public function getData() {
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL =>  $this->api_url . $this->api_key, // replacing with your API
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            return json_decode($response, true);
        }
    }

    public function getTenGames() {
        $data = $this->getData();
        // echo $data;
        return array_slice($data['results'], 0, 10);
    }
}

//= '5f4ec30e7b804e40819e2ecd80b6a6f0'; // replace this with your actual API key
//  = 'https://api.rawg.io/api/games?key=';


$df = new Games('https://api.rawg.io/api/games?key=', '5f4ec30e7b804e40819e2ecd80b6a6f0');
$tenGames = $df->getTenGames();
// var_dump($firstTen);
foreach($tenGames as $game) {
    echo $game['name'] . '<br>';
    echo $game['background_image'] . '<br>';;
    echo $game['rating'] . '<br>';;
    foreach( $game['stores'] as $store ){
       echo $store['store']['name'] . '<br>';
    }
    echo '<br>';
}
