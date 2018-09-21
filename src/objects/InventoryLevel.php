<?php

namespace Xariable\Shopify\Objects;

class InventoryLevel extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "inventory_levels";
	protected $key = "inventory_level";
	protected $omit = ['create', 'update', 'delete'];

}
