<?php

namespace Xariable\Shopify\Objects;

class Location extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "locations";
	protected $key = "location";
	protected $omit = ['create', 'update', 'delete'];

}
