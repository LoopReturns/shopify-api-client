<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class CustomerAddress extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "addresses";
	protected $key = "address";
	protected $parent = "customers";

}
