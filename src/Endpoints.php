<?php

namespace RifkyEkayama\BitcoinAPI;

/**
* Bitcoin Endpoints
*
* @author Rifky Ekayama <rifky.ekayama@gmail.com>
*/

class Endpoints {
  
  private $server_key;
  private $secret_key;
  
  public function __construct($server_key, $secret_key)
  {
    $this->server_key = $server_key;
    $this->secret_key = $secret_key;
  }

  /**
   * Fungsi untuk mendapatkan Ticker Bitcoin
   * 
   * @param string $currency jenis mata uang bitcoin
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin 
   */
  public function ticker($currency)
  {
    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->get($currency, 'ticker');
  }

  /**
   * Fungsi untuk mendapatkan Trades Bitcoin
   * 
   * @param string $currency jenis mata uang bitcoin
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin 
   */
  public function trades($currency)
  {
    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->get($currency, 'trades');
  }

  /**
   * Fungsi untuk mendapatkan Depth Bitcoin
   * 
   * @param string $currency jenis mata uang bitcoin
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin 
   */
  public function depth($currency)
  {
    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->get($currency, 'depth');
  }

  /**
   * This method gives user balances and server's timestamp.
   * 
   * @param none
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function getInfo()
  {
    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('getInfo');
  }

  /**
   * This method gives list of deposits and withdrawals of all currencies.
   * 
   * @param none
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function transHistory()
  {
    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('transHistory');
  }

  /**
   * This method is for opening a new order
   * 
   * @param See Documentation
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function trade($pair = 'btc_idr', 
                        $type = null, 
                        $price = null, 
                        $idr = null, 
                        $btc = null)
  {
    $request_params = [
      'pair' => $pair,
      'type' => $type,
      'price' => $price,
      'idr' => $idr,
      'btc' => $btc
    ];

    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('trade', $request_params);
  }

  /**
   * This method gives information about transaction in buying and selling history.
   * 
   * @param See Documentation
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function tradeHistory($count = 1000,
                               $pair = 'btc_idr',
                               $from_id = 0,
                               $end_id = null,
                               $order = 'desc',
                               $since = null,
                               $end = null)
  {
    $request_params = [
      'count' => $count,
      'from_id' => $from_id,
      'end_id' => $end_id,
      'order' => $order,
      'since' => $since,
      'end' => $end,
      'pair' => $pair
    ];

    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('tradeHistory', $request_params);
  }

  /**
   * This method gives the list of current open orders (buy and sell).
   * 
   * @param See Documentation
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function openOrders($pair = 'btc_idr')
  {
    $request_params = [
      'pair' => $pair
    ];

    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('openOrders', $request_params);
  }

  /**
   * This method gives the list of order history (buy and sell).
   * 
   * @param See Documentation
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function orderHistory($pair = 'btc_idr', $count = 100, $from = 0)
  {
    $request_params = [
      'pair' => $pair,
      'count' => $count,
      'from' => $from
    ];

    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('orderHistory', $request_params);
  }

  /**
   * Use getOrder to get specific order details.
   * 
   * @param See Documentation
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function getOrder($pair = 'btc_idr', $order_id = null)
  {
    $request_params = [
      'pair' => $pair,
      'order_id' => $order_id
    ];

    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('getOrder', $request_params);
  }

  /**
   * This method is for canceling an existing open order.
   * 
   * @param See Documentation
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function cancelOrder($pair = 'btc_idr', $order_id = null, $type = null)
  {
    $request_params = [
      'pair' => $pair,
      'order_id' => $order_id,
      'type' => $type
    ];

    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('cancelOrder', $request_params);
  }

  /**
   * This method is for withdrawing assets (except IDR).
   * 
   * To be able to use this method you need to enable withdraw permission when you generate the API
   * Key. Otherwise you will get “No permission” error.
   * 
   * You also need to prepare a Callback URL. Callback URL is a URL that our system will call to
   * verify your withdrawal requests. Various parameters will be sent to Callback URL, make sure to
   * check this information on your server side. If all the data is correct, print out a string “ok” (without
   * quotes). We will continue the request if only we receive “ok” (without quotes) response, otherwise
   * the request will be failed.
   * 
   * Callback call will be sent through a POST request, with 5 seconds connection timeout.
   * 
   * @param See Documentation
   * @return string Response dari cURL, berupa string JSON balasan dari Bitcoin
   */
  public function withdrawCoin($currency = null,
                               $withdraw_address = null,
                               $withdraw_amount = null,
                               $withdraw_memo = null,
                               $request_id = null)
  {
    $request_params = [
      'currency' => $currency,
      'withdraw_address' => $withdraw_address,
      'withdraw_amount' => $withdraw_amount,
      'withdraw_memo' => $withdraw_memo,
      'request_id' => $request_id
    ];

    $rest_client = new RESTClient($this->server_key, $this->secret_key);
    return $rest_client->post('withdrawCoin', $request_params);
  }
  
}