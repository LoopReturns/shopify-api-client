<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;

class Discount extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;
	
	## Need to customize enable/disable.

	protected $name = "discounts";
	protected $key = "discount";

}