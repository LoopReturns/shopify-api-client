<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class Transaction extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "transactions";
	protected $key = "transaction";
	protected $omit = ['update'];

}
