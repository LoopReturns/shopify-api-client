<?php

namespace RocketCode\Shopify\Objects;

use \RocketCode\Shopify\Exceptions\ShopifyException;

class Theme extends BaseObject {

    use \RocketCode\Shopify\Traits\ShopifyTransport;

    protected $name = "themes";
    protected $key = "theme";

}
