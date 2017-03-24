<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class CustomCollection extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "custom_collections";
	protected $key = "custom_collection";

}
