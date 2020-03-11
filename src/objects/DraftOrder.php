<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class DraftOrder extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "draft_orders";
	protected $key = "draft_order";


	public function complete($draft_order_id) {
		if( !isset($draft_order_id) ) {
			throw new ShopifyException( 'Invalid args: Provide a draft order id.' );
		}

		$url = $this->getShopBaseUrl() ."draft_orders/$draft_order_id/complete.json";
		$headers = $this->getRequestHeaders();

		// returns a PHP object with body & headers
		$result = $this->execute($url, "PUT", $headers);

		return $result;
	}
}
