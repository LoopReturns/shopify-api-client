<?php

namespace Xariable\Shopify\Objects;

class GraphQL extends BaseObject {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name = "inventory_items";
	protected $key = "inventory_item";
	protected $omit = ['create', 'update', 'delete', 'all'];

	public function inventory($variant_id) {
		// retrieves up to 10 Inventory Levels for a provided Shopify Product Variant ID
		$query = 'query { productVariant(id: "gid://shopify/ProductVariant/'. $variant_id .'") { inventoryItem { inventoryLevels (first:10) { edges { node { location { id name } available } } } } } }';

		// Log::debug($query ."\n");

		$headers = $this->getRequestHeaders();

		$res = $this->executeGQL($query, $headers);
		$response = json_decode($res);
		// Log::debug("--- graphql - inventory full response ---");
		// Log::debug($res);
		// Log::debug("--- --------------------------------- ---\n");

		// if the query was successful, trim the fat
		if ( isset($response->data->productVariant->inventoryItem->inventoryLevels->edges)
			&& count($response->data->productVariant->inventoryItem->inventoryLevels->edges) ) {
			return $response->data->productVariant->inventoryItem->inventoryLevels->edges;
		}

		return $response;
	}


	public function productTypes() {
		$query = 'query { shop { productTypes(first:250) { edges { node } } } }';
		// Log::debug("query: \n". $query ."\n");
		$headers = $this->getRequestHeaders();

		$res = $this->executeGQL($query, $headers);
		$response = json_decode($res);
		// Log::debug("--- graphql - inventory full response ---");
		// Log::debug($res);
		// Log::debug("--- --------------------------------- ---\n");

		if ( isset($response->data->shop->productTypes->edges)
			&& count($response->data->shop->productTypes->edges) ) {
			return $response->data->shop->productTypes->edges;
		}

		return $response;
	}



}
