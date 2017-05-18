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

trait ShopifyTransport {

	private $shopifyTransportResult;
	private $shopifyTransportClient;
	private $httpClient;

	public function execute ( $url , $method , $headers, $data=null , $wantObj=false ) {
		$this->shopifyTransportResult = null;
		$this->httpClient = new GuzzleHttp\Client();

		try {
			$attrs = array(
				'headers' => $headers
			);

			if( !is_null($data) )
				$attrs['body'] = $data;

			$this->shopifyTransportResult = $this->httpClient->request(
				strtoupper($method),
				$url,
				$attrs
			);
		}
		catch ( ClientException $e ) {
			// Throw new ShopifyException( "Shopify-Guzzle (xxx): " . $e->getMessage(), $e->getCode(), $e );
			return json_encode([
				'errors' => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}
		catch ( Exception $e ) {
			Throw new ShopifyException( "Shopify-Other: " . $e->getMessage(), $e->getCode(), $e );
		}

		if( !is_null( $this->shopifyTransportResult ) ) {
			$string = $this->shopifyTransportResult->getBody();
			return ( $wantObj ) ?
				json_decode( strval($string) )
				: strval($string);
		}

		return false;

	}
}
