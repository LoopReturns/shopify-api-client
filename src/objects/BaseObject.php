<?php
/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 1:06 PM
 */

namespace Xariable\Shopify\Objects;

use \Xariable\Shopify\Exceptions\ShopifyException;

class BaseObject extends BaseProvider {

	use \Xariable\Shopify\Traits\ShopifyTransport;

	protected $name;
	protected $key;
	protected $single_key;
	protected $omit = [];
	protected $parent;
	protected $hasParent = [];
	protected $next;
	protected $previous;
	protected $limit = 250;
	protected $page = 1;

	private function checkParent ( $f, $args ) {
		$prefix = "";
		if( ( isset( $this->parent ) and in_array( $f, $this->hasParent ) )
			OR
			( isset( $this->parent ) and count( $this->hasParent ) == 0 ) ) {
			if( is_array( $args ) ) {
				if( !array_key_exists( 'parent_id', $args ) ) {
					throw new ShopifyException( 'Invalid args: provide a parent_id' );
				}
				$prefix = "{$this->parent}/{$args['parent_id']}/";
			}
			else {
				$jsonObj = json_decode( $args );
				if( !property_exists( $jsonObj , 'parent_id' ) ) {
					throw new ShopifyException( 'Invalid args: provide a parent_id' );
				}
				$prefix = "{$this->parent}/{$jsonObj->parent_id}/";
			}
		}
		return $prefix;
	}

	# Pass in JSON
	public function create( $json ) {
		if( in_array( __FUNCTION__, $this->omit ) )
			return null;

		try {
			$prefix = $this->checkParent( __FUNCTION__ , $json);
		}
		catch ( ShopifyException $e ) {
			throw new ShopifyException( $e );
		}

		$url = $this->getShopBaseUrl() . $prefix . "{$this->name}.json";
		$headers = $this->getRequestHeaders();

		$json = json_decode( $json );
		if( property_exists( $json, 'parent_id') )
			unset( $json->parent_id );
		$json = json_encode( $json );

		$data = '{ "' . $this->key . '":' . $json . '}';
		$result = $this->execute( $url, "POST", $headers, $data );
		$result = json_decode( $result );

		if( $result and property_exists( $result, $this->key) )
			return json_encode( $result->{$this->key} );

		if ( is_string($result) )
			return $result;

		return json_encode($result);
	}

	# Pass in JSON
	public function update( $json ) {
		if( in_array( __FUNCTION__, $this->omit ) )
			return null;
		$jsonObj = json_decode( $json );
		if( !property_exists( $jsonObj , 'id' ) ) {
			throw new ShopifyException( 'Invalid args: provide a id' );
		}
		$data = '{ "' . $this->key . '" : ' . $json . ' } ';

		try {
			$prefix = $this->checkParent( __FUNCTION__ , $json);
		}
		catch ( ShopifyException $e ) {
			throw new ShopifyException( $e );
		}
		$url = $this->getShopBaseUrl() . $prefix . "{$this->name}/{$jsonObj->id}.json";
		$headers = $this->getRequestHeaders();

		$result = $this->execute( $url , "PUT" , $headers , $data );
		$result = json_decode( $result );

		if( $result and property_exists( $result, $this->key) )
			return json_encode( $result->{$this->key} );

		if ( is_string($result) )
			return $result;

		return json_encode($result);
	}

	####---- Functions below here pass in an array.

	# Pass in Array
	public function delete( $args=array() ) {
		if( in_array( __FUNCTION__, $this->omit ) )
			return null;
		if( !array_key_exists( 'id', $args ) ) {
			throw new ShopifyException( 'Invalid args: provide a id' );
		}

		try {
			$prefix = $this->checkParent( __FUNCTION__ , $args);
		}
		catch ( ShopifyException $e ) {
			throw new ShopifyException( $e );
		}
		$url = $this->getShopBaseUrl() . $prefix . "{$this->name}/{$args['id']}.json";
		$headers = $this->getRequestHeaders();

		$result = $this->execute( $url, "DELETE" , $headers);

		if( count( json_decode( $result, true ) ) == 0 )
			return true;

		return $result;
	}

	# Pass in Array
	public function find( $args=array() ) {
		if( in_array( __FUNCTION__, $this->omit ) )
			return null;
		if( !array_key_exists( 'id', $args ) ) {
			throw new ShopifyException( 'Invalid args: provide a id' );
		}

		try {
			$prefix = $this->checkParent( __FUNCTION__ , $args);
		}
		catch ( ShopifyException $e ) {
			throw new ShopifyException( $e );
		}
		$url = $this->getShopBaseUrl() . $prefix . "{$this->name}/{$args['id']}.json";
		$headers = $this->getRequestHeaders();

		if( array_key_exists( 'fields', $args ) )
			$url .= "?fields=" . implode( ',', $args['fields'] );
		$result = $this->execute( $url, "GET" , $headers);
		$result = json_decode( $result );

		if( $result and property_exists( $result, $this->key) )
			return json_encode( $result->{$this->key} );

		if ( is_string($result) )
			return $result;

		return json_encode($result);
	}

	# Pass in Array
	public function all( $args=array() ) {
		if( in_array( __FUNCTION__, $this->omit ) )
			return null;

		try {
			$prefix = $this->checkParent( __FUNCTION__ , $args);
		}
		catch ( ShopifyException $e ) {
			throw new ShopifyException( $e );
		}
		$url = $this->getShopBaseUrl() . $prefix . "{$this->name}.json";
		$headers = $this->getRequestHeaders();

		$argArray = array();
		if( array_key_exists( 'filters', $args ) ) {
			foreach( $args['filters'] as $k => $v ) {
				if($k == 'limit') {
					$this->limit = $v;
				}
			}
			foreach( $args['filters'] as $k => $v ) {
				if($k == 'page') {
					$page = $v;
					if($page == 1) {
						$argArray[] = "since_id=0";
						$this->page = $v;
					}
					elseif($page - $this->page == 1) {
						// next
						$argArray = ["page_info=" . $this->next];
						$argArray[] = "limit=" . $this->limit;
						$this->page = $v;
						break;
					}
					elseif($page - $this->page == -1) {
						// previous
						$argArray = ["page_info=" . $this->previous];
						$argArray[] = "limit=" . $this->limit;
						$this->page = $v;
						break;
					}
				} else {
					$argArray[] = "{$k}={$v}";
				}
			}
		}
		if( array_key_exists( 'fields', $args ) ) {
			foreach( $args['fields'] as $k => $v ) {
				$argArray[] = "{$k}={$v}";
			}
		}
		$url .= "?" . implode( '&', $argArray );

		$result = $this->execute( $url, "GET" , $headers);
		$result = json_decode( $result );

		if( $result and property_exists( $result, $this->name) )
			return json_encode( $result->{$this->name} );

		if ( is_string($result) )
			return $result;

		return json_encode($result);
	}

	# Pass in Array
	public function count( $args=array() ) {
		if( in_array( __FUNCTION__, $this->omit ) )
			return null;

		try {
			$prefix = $this->checkParent( __FUNCTION__ , $args);
		}
		catch ( ShopifyException $e ) {
			throw new ShopifyException( $e );
		}
		$url = $this->getShopBaseUrl() . $prefix . "{$this->name}/count.json";
		$headers = $this->getRequestHeaders();

		if( array_key_exists( 'filters', $args ) ) {
			$filterArray = array();
			foreach( $args['filters'] as $k => $v ) {
				$filterArray[] = "{$k}={$v}";
			}
			$url .= "?" . implode( '&', $filterArray );
		}

		$result = $this->execute( $url, "GET" , $headers);
		$result = json_decode( $result );

		if( $result and property_exists( $result, 'count') )
			return json_encode( $result->count );

		if ( is_string($result) )
			return $result;

		return json_encode($result);
	}
}
