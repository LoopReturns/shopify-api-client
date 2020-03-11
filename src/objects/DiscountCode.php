<?php
/**
 * User: bschmidt
 * Date: 5/18/17
 */
namespace Xariable\Shopify\Objects;

class DiscountCode extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	## Need to customize enable/disable.

	protected $name = "discount_codes";
	protected $key = "discount_code";
	protected $parent = "price_rules";

	public function lookup($code) {
		if( !isset($code) ) {
			throw new ShopifyException( 'Invalid args: Provide a discount code.' );
		}

		$url = $this->getShopBaseUrl() ."discount_codes/lookup.json?code=". urlencode($code);
		$headers = $this->getRequestHeaders();

		// returns a PHP object with body & headers
		$result = $this->executeWithHeaders($url, "GET", $headers);

		return $result;
	}

}
