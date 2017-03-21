<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 4:25 PM
 */

namespace RocketCode\Shopify\Exceptions;


class ShopifyException extends \Exception {

	public function __construct( $msg , $code = 0 , \Exception $prev = null ) {
		parent::__construct($msg, $code, $prev);
	}

	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}