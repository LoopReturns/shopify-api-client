<?php

namespace Xariable\Shopify\Objects;

use \Xariable\Shopify\Exceptions\ShopifyException;

class Theme extends BaseObject {

    use \Xariable\Shopify\Traits\ShopifyTransport;

    protected $name = "themes";
    protected $key = "theme";

}
