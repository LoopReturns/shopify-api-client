<?php

namespace Xariable\Shopify\Objects;

use \Xariable\Shopify\Exceptions\ShopifyException;

class Collection extends BaseObject
{
    use \Xariable\Shopify\Traits\ShopifyTransport;

    protected $name = 'collections';
    protected $key = 'collection';

    /**
     * @param string $collectionId
     * @param array $filters
     * @return bool|string
     * @throws ShopifyException
     */
    public function products($collectionId, array $filters = [])
    {
        if (! isset($collectionId)) {
            throw new ShopifyException('Invalid args: Provide a collection ID.');
        }

        $url = $this->getShopBaseUrl() . 'collections/' . $collectionId . '/products.json';
        if (! empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }

        $headers = $this->getRequestHeaders();

        $result = $this->execute($url, 'GET', $headers);

        if (is_string($result)) {
            return $result;
        }

        return json_encode($result);
    }
}
