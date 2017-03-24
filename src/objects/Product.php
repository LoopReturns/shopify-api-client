<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

use \Xariable\Shopify\Exceptions\ShopifyException;

class Product extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "products";
	protected $key = "product";

}
