<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class Discount extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	## Need to customize enable/disable.

	protected $name = "discounts";
	protected $key = "discount";

}
