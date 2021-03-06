<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class Refund extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "refunds";
	protected $key = "refund";
	protected $parent = "orders";
	protected $omit = ['update'];

	## Need to customize 'calculate'

}
