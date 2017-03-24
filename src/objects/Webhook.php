<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class Webhook extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = 'webhooks';
	protected $key = 'webhook';

}
