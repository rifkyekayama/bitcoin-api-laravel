<?php 

namespace RifkyEkayama\BitcoinAPI;

/**
* Bitcoin REST Client
*
* @author Rifky Ekayama <rifky.ekayama@gmail.com>
*/
class RESTClient {
	
	private $server_key;
	private $secret_api_url;
	private $public_api_url;
	
	public function __construct($server_key, $secret_key) {
		$this->server_key = $server_key;
		$this->secret_key = $secret_key;
		$this->secret_api_url = 'https://vip.bitcoin.co.id/tapi/';
		$this->public_api_url = 'https://vip.bitcoin.co.id/api/';
	}

	/**
	* HTTP GET method
	*
	* @param array Parameter yang dikirimkan
	* @return string Response dari cURL
	*/
	public function get($currency, $type) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->public_api_url . "/" . $currency . "/" . $type);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_ENCODING, "");
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		$request = curl_exec($curl);
		$return = ($request === FALSE) ? curl_error($curl) : $request;
		curl_close($curl);
		return $return;
	}
	
	/**
	* HTTP POST method
	*
	* @param array Parameter yang dikirimkan
	* @return string Response dari cURL
	*/
	public function post($method, array $req = array()) {
		// API settings
		$key = $this->server_key; // your API-key
		$secret = $this->secret_key; // your Secret-key
		$req['method'] = $method;
		$req['nonce'] = time();
		
		// generate the POST data string
		$post_data = http_build_query($req, '', '&');
		$sign = hash_hmac('sha512', $post_data, $secret);

		// generate the extra headers
		$headers = array(
			'Sign: '.$sign,
			'Key: '.$key,
		);

		// our curl handle (initialize if required)
		static $ch = null;
		if (is_null($ch)) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible;BITCOINCOID PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
		}
		curl_setopt($ch, CURLOPT_URL, $this->secret_api_url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		// run the query
		$res = curl_exec($ch);
		if ($res === false){
			throw new Exception('Could not get reply:'.curl_error($ch));
		}
		$dec = json_decode($res, true);
		if (!$dec){
			throw new Exception('Invalid data received, please make sure connection is working and requested API exists: '.$res);
		}
		
		curl_close($ch);
		$ch = null;
		return $dec;
	}
	
}