<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class Customer extends BaseObject
{

    use \Xariable\Shopify\Traits\ShopifyTransport;

    protected $name = "customers";
    protected $key = "customer";

    # Pass in Array
    public function search($args = array())
    {
        $url = $this->getShopBaseUrl() . "{$this->name}/search.json";

        if (array_key_exists('query', $args)) {
            $url .= "?query=" . $args['query'];
        }

        $headers = $this->getRequestHeaders();

        $result = $this->execute($url, "GET", $headers);
        $result = json_decode($result);

        if ($result and property_exists($result, 'customers')) {
            if (count($result->customers) == 0) {
                return "";
            }
            return json_encode($result->{'customers'});
        }

        return $result;
    }
}
