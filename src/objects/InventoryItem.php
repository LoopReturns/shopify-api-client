<?php

namespace Xariable\Shopify\Objects;

class InventoryItem extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "inventory_items";
	protected $key = "inventory_item";
	protected $omit = ['create', 'update', 'delete'];

}
