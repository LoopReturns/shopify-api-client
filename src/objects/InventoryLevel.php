<?php

namespace Xariable\Shopify\Objects;

use Xariable\Shopify\Exceptions\ShopifyException;

class InventoryLevel extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "inventory_levels";
	protected $key  = "inventory_level";
	protected $omit = ['create', 'update', 'delete'];


	/**
	 * adjust [POST]
	 */
	public function adjust($data) {
		/* Example payload (only one item per request)

		[POST] https://{shop}.myshopify.com/admin/inventory_levels/adjust.json

		{
			"location_id": 6884556842,
			"inventory_item_id": 12250274365496,
			"available_adjustment": 1
		}
		*/

		if ( !isset($data['location_id']) || !isset($data['inventory_item_id']) || !isset($data['available_adjustment']) )
			throw new ShopifyException( 'Invalid args: Provide a inventory adjustment payload.' );

		$url     = $this->getShopBaseUrl() .'inventory_levels/adjust.json';
		$headers = $this->getRequestHeaders();

		// returns a PHP object with body & headers
		$result = $this->execute($url, 'POST', $headers, json_encode($data));

		return $result;
	}

}