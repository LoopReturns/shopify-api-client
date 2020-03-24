<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/15/16
 * Time: 10:16 PM
 */

namespace Xariable\Shopify\Objects;


class BaseProvider {
	private $domain, $apiKey, $apiPass;
	private $shopBaseUrl;
	private $accessToken, $shopDomain;
	private $headers;

	private $shopify_api_version = '2020-01';

	public function __construct($args) {

		if (isset($args[0]['domain']) && isset($args[0]['access_token'])) {
			$this->accessToken = $args[0]['access_token'];
			$this->shopDomain = $args[0]['domain'];
			$this->_makePublicUrl();
		}
		else {
			$this->apiKey = getenv('SHOP_API_KEY');
			$this->apiPass = getenv('SHOP_API_PASSWORD');
			$this->domain = getenv('SHOP_DOMAIN');
			$this->_makePrivateUrl();
		}
	}

	/*
	* Depricated function only used in a test.
	*/
	public function _makeUrl() {
		$url =
			"https://" . $this->apiKey
			. ":" . $this->apiPass
			. "@" . $this->domain;
		$this->shopBaseUrl  = $url;
	}

	public function _makePublicUrl() {
		$this->shopBaseUrl  = "https://" . $this->shopDomain;

		$this->headers = array(
			'Content-Type' => 'application/json' ,
			'Accept' => '*/*',
			'X-Shopify-Access-Token' => $this->accessToken,
			'X-Shopify-Api-Features' => 'include-presentment-prices'
		);
	}

	public function _makePrivateUrl() {
		$url =
			"https://" . $this->apiKey
			. ":" . $this->apiPass
			. "@" . $this->domain;
		$this->shopBaseUrl  = $url;


		$this->headers = array(
			'Content-Type' => 'application/json' ,
			'Accept' => '*/*'
		);
	}

	public function getApiKey() {
		return $this->apiKey;
	}

	public function getApiPass() {
		return $this->apiPass;
	}

	public function getDomain() {
		return $this->domain;
	}

	public function getShopBaseUrl() {
		return $this->shopBaseUrl . '/admin/api/' . $this->shopify_api_version . '/';
	}

	public function getShopGraphQLUrl() {
		return $this->shopBaseUrl . '/admin/api/' . $this->shopify_api_version . '/graphql.json';
	}

	public function getRequestHeaders() {
		return $this->headers;
	}

	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
	}

	public function setApiPass($apiPass) {
		$this->apiPass = $apiPass;
	}

	public function setDomain($domain) {
		$this->domain = $domain;
	}

	public function setShopBaseUrl($shopBaseUrl) {
		$this->shopBaseUrl = $shopBaseUrl;
	}
}
