<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;

class Fulfillment extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = "fulfillments";
	protected $key = "fulfillment";

}