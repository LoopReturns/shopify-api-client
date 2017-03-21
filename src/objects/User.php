<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;

class User extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = 'users';
	protected $key = 'user';
	protected $omit = ['count','update','delete'];

	## Need to customize logged in user.

}