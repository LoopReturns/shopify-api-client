<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;

class Collect extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = "collects";
	protected $key = "collect";
	protected $omit = [ 'update' ];

}