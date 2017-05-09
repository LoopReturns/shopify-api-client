<?php
namespace Xariable\Shopify\Objects;

class RecurringApplicationCharge extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "recurring_application_charges";
	protected $key = "recurring_application_charge";
}
