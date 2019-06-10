<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 4:11 PM
 */

namespace Xariable\Shopify\Traits;

use Exception;
use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;
use Xariable\Shopify\Exceptions\ShopifyException;
use App\Classes\Counter;

trait ShopifyTransport {

	private $shopifyTransportResult;
	private $shopifyTransportClient;
	private $httpClient;

	public function execute($url, $method, $headers, $data = null, $want_obj = false) {
		$this->shopifyTransportResult = null;
		$this->httpClient = new GuzzleHttp\Client();

		try {
			$attrs = array(
				'headers' => $headers
			);

			if( !is_null($data) )
				$attrs['body'] = $data;

			Counter::inc('shopify', $this->name ?? 'default');

			$this->shopifyTransportResult = $this->httpClient->request(
				strtoupper($method),
				$url,
				$attrs
			);
		}
		catch ( ClientException $e ) {
			return json_encode([
				'errors'  => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}
		catch ( Exception $e ) {
			return json_encode([
				'errors'  => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}

		if ( !is_null( $this->shopifyTransportResult ) ) {
			$string = strval($this->shopifyTransportResult->getBody());

			if ( $want_obj )
				return json_decode($string);

			return $string;
		}

		return false;
	}

	public function executeWithHeaders($url, $method, $headers, $data = null) {
		$this->shopifyTransportResult = null;
		$this->httpClient = new GuzzleHttp\Client();

		try {
			$attrs = array(
				'headers'          => $headers,
				'allow_redirects'  => false
			);

			if( !is_null($data) )
				$attrs['body'] = $data;

			Counter::inc('shopify', $this->name ?? 'default');

			$this->shopifyTransportResult = $this->httpClient->request(
				strtoupper($method),
				$url,
				$attrs
			);
		}
		catch ( ClientException $e ) {
			return json_encode([
				'errors'  => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}
		catch ( Exception $e ) {
			return json_encode([
				'errors'  => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}

		if( !is_null($this->shopifyTransportResult) ) {
			$response = [
				"code"     => $this->shopifyTransportResult->getStatusCode(),
				"body"     => $this->shopifyTransportResult->getBody(),
				"headers"  => $this->shopifyTransportResult->getHeaders()
			];

			return json_encode($response);
		}

		return false;
	}

}