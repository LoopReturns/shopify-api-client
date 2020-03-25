<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class AccessScope extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "access_scopes";
	protected $key = "access_scope";
	protected $parent = "oauth";

	protected $omit = [ 'create', 'update', 'delete', 'find', 'count' ];


	public function all($args = []) {
		if ( in_array( __FUNCTION__, $this->omit) )
			return null;

		$url      = $this->getNoVersionShopBaseUrl() . "oauth/access_scopes.json";
		$headers  = $this->getRequestHeaders();

		$result = $this->execute( $url, "GET" , $headers);
		$result = json_decode( $result );

		if ( $result && property_exists($result, $this->name) )
			return json_encode($result->{$this->name});

		if ( is_string($result) )
			return $result;

		return json_encode($result);
	}

}
