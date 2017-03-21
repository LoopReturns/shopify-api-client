<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace RocketCode\Shopify\Objects;

class MetaField extends BaseObject {

	use \RocketCode\Shopify\Traits\ShopifyTransport;

	protected $name = "metafields";
	protected $key = "metafield";
	protected $parent = "";
	public function setParent($parent) {
		$this->parent = $parent;
	}
}