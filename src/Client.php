<?php

/**
 * Created by PhpStorm.
 * User: tonysantucci
 * Date: 5/9/16
 * Time: 12:31 PM
 */

namespace Xariable\Shopify;

class Client {

	private static function __setDefinedObjects() {
		$objects = array();
		foreach ( new \DirectoryIterator(dirname( __FILE__ ) . '/objects') as $fi ) {
			if( $fi->isDot() ) continue;
			$name = $fi->getBasename( '.php' );
			require_once join( '/', array( dirname( __FILE__ ), 'objects', $name . '.php' ) );
			$objects[] = $name;
		}

		foreach ( new \DirectoryIterator(dirname( __FILE__ ) . '/traits') as $fi ) {
			if( $fi->isDot() ) continue;
			$name = $fi->getBasename( '.php' );
			require_once join( '/', array( dirname( __FILE__ ), 'traits', $name . '.php' ) );
		}

		return $objects;
	}

	public static function __callstatic ( $name , $args=null ) {
		$objects = self::__setDefinedObjects();
		if( in_array( $name , $objects ) ) {
			$string = "\Xariable\Shopify\Objects\\" . $name;
			//print "$string\n";
			return new $string( $args );
		}
	}
}
