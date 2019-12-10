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

	public function execute($url, $method, $headers, $data = null, $want_obj = false) {
		$this->shopifyTransportResult = null;
		$this->httpClient = new GuzzleHttp\Client();

		try {
			$attrs = array(
				'headers' => $headers
			);

			if( !is_null($data) )
				$attrs['body'] = $data;

			if(class_exists('\App\Classes\Counter')) {
				\App\Classes\Counter::inc('shopify', $this->name ?? 'default');
			}

			$this->shopifyTransportResult = $this->httpClient->request(
				strtoupper($method),
				$url,
				$attrs
			);
		}
		catch ( ClientException $e ) {
			// Self rollback to avoid Shopify throttling
			if ( !is_null( $this->shopifyTransportResult ) ) {
				$result_headers  = $this->shopifyTransportResult->getHeaders();
				$this->shouldLimit($result_headers, $method, $url);
			}
			else if ( $e->getCode() == 429 ) {
				usleep(2000000);
			}
			return json_encode([
				'errors'  => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}
		catch ( Exception $e ) {
			// Self rollback to avoid Shopify throttling
			if ( !is_null( $this->shopifyTransportResult ) ) {
				$result_headers  = $this->shopifyTransportResult->getHeaders();
				$this->shouldLimit($result_headers, $method, $url);
			}
			else if ( $e->getCode() == 429 ) {
				usleep(2000000);
			}
			return json_encode([
				'errors'  => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}

		if ( !is_null( $this->shopifyTransportResult ) ) {
			$string = strval($this->shopifyTransportResult->getBody());

			// Self rollback to avoid Shopify throttling
			$result_headers  = $this->shopifyTransportResult->getHeaders();
            $this->shouldLimit($result_headers, $method, $url);

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

			if(class_exists('\App\Classes\Counter')) {
				\App\Classes\Counter::inc('shopify', $this->name ?? 'default');
			}

			$this->shopifyTransportResult = $this->httpClient->request(
				strtoupper($method),
				$url,
				$attrs
			);
		}
		catch ( ClientException $e ) {
			// Self rollback to avoid Shopify throttling
			if ( !is_null( $this->shopifyTransportResult ) ) {
				$result_headers  = $this->shopifyTransportResult->getHeaders();
				$this->shouldLimit($result_headers, $method, $url);
			}
			else if ( $e->getCode() == 429 ) {
				usleep(2000000);
			}
			return json_encode([
				'errors'  => $e->getCode(),
				'message' => $e->getMessage()
			]);
		}
		catch ( Exception $e ) {
			// Self rollback to avoid Shopify throttling
			if ( !is_null( $this->shopifyTransportResult ) ) {
				$result_headers  = $this->shopifyTransportResult->getHeaders();
				$this->shouldLimit($result_headers, $method, $url);
			}
			else if ( $e->getCode() == 429 ) {
				usleep(2000000);
			}
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

			// Self rollback to avoid Shopify throttling
            $result_headers  = $this->shopifyTransportResult->getHeaders();
            $this->shouldLimit($result_headers, $method, $url);

			return json_encode($response);
		}

		return false;
	}

	private function shouldLimit($headers, $method, $url) {
    	if ( isset($headers['X-Shopify-Shop-Api-Call-Limit'][0]) ) {

    		$site = getenv('APP_DOMAIN');

			try {
				error_log(date("Y-m-d H:i:s") . ' - ' . ($headers['X-Shopify-Shop-Api-Call-Limit'][0] ?? 'no limit header') . ' ' . strtoupper($method) . " " . $url . "\n", '3', '/home/forge/'.$site.'/storage/logs/shopify-' . date("Y-m-d") . '.log');
			} catch(Exception $e) {
				error_log(date("Y-m-d H:i:s") . ' - Error: ' . $e->getMessage(). "\n", '3', '/home/forge/'.$site.'/storage/logs/shopify-' . date("Y-m-d") . '.log');
			}

			$limits = explode('/', $headers['X-Shopify-Shop-Api-Call-Limit'][0]);

            if ( gettype($limits) == 'array' ) {
                \Log::debug('limit ' . $headers['X-Shopify-Shop-Api-Call-Limit'][0]);
                \Log::debug('limit type ' . gettype($headers['X-Shopify-Shop-Api-Call-Limit']));
                \Log::debug('limit split ' . json_encode($limits));

				//40/20 = 2, 80 / 20 = 4, 120 / 20 = 6, 160 / 20 = 8
				if ( $limits[1] == 0 ) {
					return true;
				}

                $rate = ($limits[0] / $limits[1]) * 100;
                \Log::debug('Rate '. $rate);
                if ($rate > 75) {
                    if ( $rate > 95 ) { // 38/40
                        // wait for 1 1/3 seconds
                        usleep(1333333);
                    }
                    else if  ( $rate > 85 ) { // 35/40
                        // wait for 1/2 seconds
                        usleep(500000);
                    }
                    else if  ( $rate > 70 ) { // 30/40
                        // wait for 1/3 seconds
                        usleep(333333);
                    }

                }
            }
        }
        return true;
     }

}
