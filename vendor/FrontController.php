<?php

/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:08
 */

namespace Vendor;

/**
 * Class FrontController
 *
 * @package Vendor
 */
class FrontController extends Core
{

	/**
	 * Defaults value
	 *
	 * @var string
	 */
	private $controller = 'Master';

	/**
	 * Defaults value
	 *
	 * @var string
	 */
	private $method = 'index';

	/**
	 * @var array
	 */
	private $param = array ( '' );

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var
	 */
	protected $router;

	/**
	 * @var array
	 */
	protected $path = array ();

	/**
	 * Constructor for FrontController
	 */
	public function __construct ()
	{
		$this->path    = Router::getInstance ()->getRouterPath ();
		$this->request = Request::init ();
		$this->init ();
	}

	/**
	 *
	 */
	private function init ()
	{
		$request    = $this->getRequest ();
		$components = $this->getCleanComponents ( $request );

		if ( $this->isMasterController ( $components ) ) {
			$this->method     = ( isset( $components[ 1 ] ) ? $components[ 1 ] : $this->method );
			$controller_class = 'Vendor\Controllers\\' . ucfirst ( $this->controller ) . '_Controller';
			$method           = $this->method;
		} else {
			$realpath = '/' . $components[ 0 ] . ( isset( $components[ 1 ] ) ? '/' . $components[ 1 ] : '' );
			$clear    = false;
			if ( false !== strpos ( $realpath, '?' ) ) {
				$realpath = explode ( '/?', $realpath )[ 0 ];
				$clear    = true;
			}
			foreach ( $this->path as $name => $path ) {
				if ( ( $path === $realpath ) ) {
					if ( count ( $components ) == 1 ) {
						$components = explode ( '/', $components[ 0 ] );
					}
					if ( $clear ) {
						unset( $components[ 1 ] );
					}
					$this->controller = trim ( ucfirst ( $components[ 0 ] ) );
					$this->method     = ( isset( $components[ 1 ] ) ? trim ( $components[ 1 ] ) : $this->method );

					if ( isset( $components[ 2 ] ) ) {
						$this->param = explode ( '/', $components[ 2 ] );
					}
					$controller_class = 'src\Controllers\\' . $this->controller . '_Controller';
					$method           = $this->method . 'Action';
					break;
				}
			}
		}

		$this->run ( $controller_class, $method );
	}

	/**
	 * Include Class and Method if exist
	 *
	 * @param $controller_class
	 * @param $method
	 *
	 * @throws \Exception
	 */
	private function run ( $controller_class, $method )
	{
		if ( empty( $controller_class ) ) {
			throw new \Exception( "This route is not in router.php config" );
		} else {
			$instance = new $controller_class();
			if ( method_exists ( $instance, $method ) ) {
				call_user_func_array ( array ( $instance, $method ), $this->param );
			} else {
				call_user_func_array ( array ( $instance, 'index' ), array ( '' ) );
			}
		}
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	private function getRequest ()
	{
		if ( !$this->isEmptyRequest () ) {
			if ( 0 === strpos ( $this->request->getRequest (), FILE_PATH ) ) {
				$request = substr ( $this->request->getRequest (), strlen ( FILE_PATH ) );
			} else {
				$request = substr ( $this->request->getRequest (), 1 );
			}
		} else {
			throw new \Exception( "Request is empty" );
		}

		return $request;
	}

	/**
	 * @return array
	 */
	private function getScriptName ()
	{
		return explode ( '/', substr ( $this->request->getScriptName (), 1, -10 ) );
	}

	/**
	 * @return bool
	 */
	private function isEmptyRequest ()
	{
		if ( empty( $this->request->getRequest () ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $request
	 *
	 * @return array
	 */
	private function getCleanComponents ( $request )
	{
		$components = explode ( '/', $request, 3 );
		if ( count ( $this->getScriptName () ) > 0 ) {
			foreach ( $this->getScriptName () as $key => $value ) {
				if ( in_array ( $value, $components ) ) {
					unset( $components[ $key ] );
				}

			}
		}

		$components = array_values ( $components );

		$components = explode ( '/', $components[ 0 ] );
		$components = $this->clean ( $components );

		return $components;
	}

	/**
	 * @param $components
	 *
	 * @return bool
	 */
	private function isMasterController ( $components )
	{
		if ( $components[ 0 ] === '' || false !== strpos ( $components[ 0 ], '?' ) ) {
			return true;
		} else {
			return false;
		}
	}

	private function clean ( $elem )
	{
		if ( !is_array ( $elem ) ) {
			$elem = htmlentities ( $elem, ENT_QUOTES, "UTF-8" );
		} else {
			foreach ( $elem as $key => $value ) {
				$elem[ $key ] = $this->clean ( $value );
			}
		}

		return $elem;
	}

}
