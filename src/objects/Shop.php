<?php
/**
 * Created by PhpStorm.
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class Shop extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "shop";
    protected $key = "shop";

    protected $omit = ['create', 'update', 'delete', 'find', 'count'];

}
