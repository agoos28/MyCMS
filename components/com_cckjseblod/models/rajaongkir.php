<?php 

class rajaOngkir{

    private $api_key;
    private $account_type;

    public function __construct() {
        $this->api_key = 'a210f2a0f1dc3b5ff7833a825d01fe00';
        $this->account_type = 'pro';
    }


    public function province($province_id = NULL) {
        $params = (is_null($province_id)) ? array() : array('id' => $province_id);
        return rajaOngkir::get($params, 'province');
    }


    public function city($province_id = NULL, $city_id = NULL) {
        $params = (is_null($province_id)) ? array() : array('province' => $province_id);
        if (!is_null($city_id)) {
            $params['id'] = $city_id;
        }
        return rajaOngkir::get($params, 'city');
    }
		
		public function subdistrict($city_id = NULL) {
				$params = array();
        if (!is_null($city_id)) {
            $params['city'] = $city_id;
        }
        return rajaOngkir::get($params, 'subdistrict');
    }

    public function cost($origin, $origin_type, $destination, $destination_type, $weight, $courier) {
        $params = array(
            'origin' => $origin,
						'originType' => $origin_type,
            'destination' => $destination,
						'destinationType' => $destination_type,
            'weight' => $weight,
            'courier' => $courier
        );
        return rajaOngkir::post($params, 'cost');
    }

    public function internationalOrigin($province_id = NULL, $city_id = NULL) {
        $params = (is_null($province_id)) ? array() : array('province' => $province_id);
        if (!is_null($city_id)) {
            $params['id'] = $city_id;
        }
        return rajaOngkir::get($params, 'v2/internationalOrigin');
    }

    public function internationalDestination($country_id = NULL) {
        $params = (is_null($country_id)) ? array() : array('id' => $country_id);
        return rajaOngkir::get($params, 'v2/internationalDestination');
    }

    public function internationalCost($origin, $destination, $weight, $courier) {
        $params = array(
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        );
        return rajaOngkir::post($params, 'v2/internationalCost');
    }

    public function currency() {
        return rajaOngkir::get(array(), 'currency');
    }

    public function waybill($waybill_number, $courier) {
        $params = array(
            'waybill' => $waybill_number,
            'courier' => $courier
        );
        return rajaOngkir::post($params, 'waybill');
    }
		
		
		function post($params = array(), $endpoint = null) {
        $curl = curl_init();
				
				$query = http_build_query($params);

				curl_setopt_array($curl, array(
					CURLOPT_URL => 'http://pro.rajaongkir.com/api/' . $endpoint,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $query,
					CURLOPT_REFERER => 'http://muamalahanak.com/staging/checkout',
					CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
					CURLOPT_HTTPHEADER => array(
						"content-type: application/x-www-form-urlencoded",
						'key: a210f2a0f1dc3b5ff7833a825d01fe00'
					),
				));
				
				$response = curl_exec($curl);
				$err = curl_error($curl);
				
				/*print_r($query);echo'r/n/';
				print_r($response);echo'r/n/';
				print_r(curl_getinfo($curl));die();*/
				curl_close($curl);
				
				if ($err) {
				die( "cURL Error #:" . $err);
			} else {
				return $response;
			}
				
    }

    function get($params = array(), $endpoint = null) {

        $query = http_build_query($params);
				
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://pro.rajaongkir.com/api/' . $endpoint . "?" . $query,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					'key: a210f2a0f1dc3b5ff7833a825d01fe00'
				),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
				die( "cURL Error #:" . $err);
			} else {
				return $response;
			}
    }

}
