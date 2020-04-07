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
		$site = getenv('APP_DOMAIN');

		try {
			$attrs = array(
				'headers' => $headers
			);

			if( !is_null($data) ) {
				$attrs['body'] = $data;
				//error_log(date("Y-m-d H:i:s") . ' ' . json_encode($data, JSON_PRETTY_PRINT) . "\n", '3', '/home/forge/'.$site.'/storage/logs/shopify-' . date("Y-m-d") . '.log');
			}

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
			$this->storePageInfo($result_headers);
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
		$site = getenv('APP_DOMAIN');

		try {
			$attrs = array(
				'headers'          => $headers,
				'allow_redirects'  => false
			);

			if( !is_null($data) ) {
				$attrs['body'] = $data;
				//error_log(date("Y-m-d H:i:s") . ' ' . json_encode($data, JSON_PRETTY_PRINT) . "\n", '3', '/home/forge/'.$site.'/storage/logs/shopify-' . date("Y-m-d") . '.log');
			}

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
			$this->storePageInfo($result_headers);
            $this->shouldLimit($result_headers, $method, $url);

			return json_encode($response);
		}

		return false;
	}

	/**
	 * execute
	 *
	 * Execute a query against a shop's GraphQL endpoint
	 *
	 * @param string - GraphQL query
	 * @param boolean - object requested?
	 *
	 * @return string (JSON) or object
	 */
	private function executeGQL($query, $headers, $want_obj = false) {

		$this->shopifyTransportResult = null;
		$this->httpClient = new GuzzleHttp\Client();

		// define request payload
		$request_data = [
			'headers' => $headers,
			'body' => json_encode([
				'query' => $query
			])
		];

		// execute query in Shopify
		try {
			$this->shopifyTransportResult = $this->httpClient->request(
				'POST',
				$this->getShopGraphQLUrl(),
				$request_data
			);
		}
		catch ( ClientException $e ) {
			// Throw new ShopifyException( "Shopify-Guzzle (xxx): " . $e->getMessage(), $e->getCode(), $e );
			Log::error("GraphQL: error executing query..");

			return json_encode([
				'errors'   => $e->getCode(),
				'message'  => $e->getMessage()
			]);
		}
		catch ( Exception $e ) {
			// Throw new ShopifyException( "Shopify-Other: " . $e->getMessage(), $e->getCode(), $e );
			Log::error("GraphQL: error executing query..");

			return json_encode([
				'errors'   => $e->getCode(),
				'message'  => $e->getMessage()
			]);
		}

		// determine return value
		if ( !is_null($this->shopifyTransportResult) ) {
			$string = $this->shopifyTransportResult->getBody();
			return ( $want_obj ) ? json_decode(strval($string)) : strval($string);
		}

		return false;
	}


	public function extractPageInfo($l) {
		$this->previous = '';
		$this->next = '';
		$m = [];
		$n = [];
		preg_match('/page_info=(.*)>/',$l,$m);
		preg_match('/rel="(.*)"/',$l,$n);
		if($n[1] == 'previous') {
			$this->previous = $m[1];
		}
		if($n[1] == 'next') {
			$this->next = $m[1];
		}
	}

	public function storePageInfo($headers)
	{
		if ( isset($headers['Link'][0]) ) {
			$h = $headers['Link'][0];
			$ha = explode(',',$h);
			if(isset($ha[0])) {
				$this->extractPageInfo($ha[0]);
			}
			if(isset($ha[1])) {
				$this->extractPageInfo($ha[1]);
			}
		}
	}

	private function shouldLimit($headers, $method, $url) {
    	if ( isset($headers['X-Shopify-Shop-Api-Call-Limit'][0]) ) {

            $logLocation = storage_path('/logs/shopify-' . date("Y-m-d") . '.log');

            try {
                error_log(date("Y-m-d H:i:s") . ' - ' . ($headers['X-Shopify-Shop-Api-Call-Limit'][0] ?? 'no limit header') . ' ' . strtoupper($method) . " " . $url . "\n", '3', $logLocation);
            } catch(Exception $e) {
                error_log(date("Y-m-d H:i:s") . ' - Error: ' . $e->getMessage(). "\n", '3', $logLocation);
            }

			$limits = explode('/', $headers['X-Shopify-Shop-Api-Call-Limit'][0]);

            if ( gettype($limits) == 'array' ) {
                //\Log::debug('limit ' . $headers['X-Shopify-Shop-Api-Call-Limit'][0]);
                //\Log::debug('limit type ' . gettype($headers['X-Shopify-Shop-Api-Call-Limit']));
                //\Log::debug('limit split ' . json_encode($limits));

				//40/20 = 2, 80 / 20 = 4, 120 / 20 = 6, 160 / 20 = 8
				if ( $limits[1] == 0 ) {
					return true;
				}

                $rate = ($limits[0] / $limits[1]) * 100;
                //\Log::debug('Rate '. $rate);
                if ($rate > 75) {
                    if ( $rate > 95 ) { // 38/40
                        // wait for 1 1/3 seconds
                        usleep(1333333);
                    }
                    else if  ( $rate > 85 ) { // 35/40
                        // wait for 1/2 seconds
                        usleep(500000);
                    }
                    else { // 30/40
                        // wait for 1/3 seconds
                        usleep(333333);
                    }

                }
            }
        }
        return true;
     }

}
