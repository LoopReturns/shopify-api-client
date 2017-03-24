<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

class MetaField extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "metafields";
	protected $key = "metafield";
	protected $parent = "";
	public function setParent($parent) {
		$this->parent = $parent;
	}
}
