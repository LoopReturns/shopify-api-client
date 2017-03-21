<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;

class Webhook extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = 'webhooks';
	protected $key = 'webhook';

}