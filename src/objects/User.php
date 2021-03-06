<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class User extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = 'users';
	protected $key = 'user';
	protected $omit = ['count','update','delete'];

	## Need to customize logged in user.

}
