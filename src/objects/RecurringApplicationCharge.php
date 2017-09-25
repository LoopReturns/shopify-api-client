<?php
namespace Xariable\Shopify\Objects;
use \Xariable\Shopify\Exceptions\ShopifyException;

class RecurringApplicationCharge extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "recurring_application_charges";
	protected $key = "recurring_application_charge";

	/**
	* activate
	*
	* @param object - Recurring Application Charge
	*/
	public function activate( $charge ) {

		$url = $this->getShopBaseUrl() ."/admin/{$this->name}/". $charge->id ."/activate.json";

		$headers        = $this->getRequestHeaders();
		$json           = json_encode($charge);
		$data           = '{ "' . $this->key . '":' . $json . '}';

		$res    = $this->execute( $url, "POST", $headers, $data );
		$result = json_decode( $res );

		if( $result and property_exists( $result, 'recurring_application_charges') ) {
			if( count( $result->recurring_application_charges ) == 0 )
				return "";

			return json_encode( $result->{'recurring_application_charges'} );
		}

	}
}
