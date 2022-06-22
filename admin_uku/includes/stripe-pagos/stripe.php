<?php
	
	/*
		Dependencias 
		curl, although you can use your own non-cURL client if you prefer
		json
		mbstring (Multibyte String)
	*/

 	// Config desde MySql
	$sqlStripe = sprintf("SELECT * FROM 
								tbl_stripe_confg 
							WHERE 
								sc_id=1");
	$rs_sqlStripe = mysqli_query($_conexion, $sqlStripe);
	$row_sqlStripe = mysqli_fetch_assoc($rs_sqlStripe);
	$checkStripe = false;
	$apiKeyTest = $row_sqlStripe["sc_apikey_test"];
	$apiKeyLive = $row_sqlStripe["sc_apikey_live"];
	if ($row_sqlStripe["sc_test"] == 1) {
		$checkStripe = true;
	}


	define('INC_STRIPE_API_LIB', dirname( __FILE__ ) . '/' );
	define('INC_STRIPE_TEST_MODE', $checkStripe );
	define('INC_STRIPE_API_KEY_TEST', $apiKeyTest );
	define('INC_STRIPE_API_KEY_LIVE', $apiKeyLive );

	require_once( INC_STRIPE_API_LIB . 'stripe-php/init.php');

	/**
	* 
	*/
	class ClassIncStripe
	{
		
		public $secretKey;

		function __construct()
		{
			$this->secretKey = INC_STRIPE_TEST_MODE ? trim( INC_STRIPE_API_KEY_TEST ) : trim( INC_STRIPE_API_KEY_LIVE ) ;
			\Stripe\Stripe::setApiKey( $this->secretKey );
			
		}

		// Productos
		public function existProduct( $id )
		{
			try{
				$product = \Stripe\Product::retrieve( $id );
			} catch (Exception $e) {
		  		$err = $e->getJsonBody();
		  		$err['error']['resource_missing'];
		  		return false;
			}

			return true;
		}

		public function createProduct( $name, $type )
		{
			try{
				$product = \Stripe\Product::create(array(
				  "name" => $name,
				  "type" => $type,
				));
			} catch (Exception $e) {
		  		$err = $e->getJsonBody();
		  		return $err;
			}

			return $product;
		}

		public function updateProductName( $id, $value )
		{
			$product = \Stripe\Product::retrieve( $id );
			$product->name = $value;
			$product->save();

			return $product;
		}

		public function deleteProduct ( $id )
		{
			$product = \Stripe\Product::retrieve( $id );
			$product->delete();
		}

		// Plans
		public function createPlan( $product_id, $data, $pre )
		{
			try{
				$plan = \Stripe\Plan::create(array(
				  "nickname" => $data[$pre.'-name'],
				  "amount" => $data[$pre.'-amount'],
				  "interval" => $data[$pre.'-interval'],
				  "interval_count" => $data[$pre.'-interval_count'],
				  "trial_period_days" => $data[$pre.'-trial_period_days'],
				  "product" => $product_id,
				  "currency" => $data[$pre.'-currency'],
				  "id" => $data[$pre.'-slug_name']
				));
			} catch (Exception $e) {
		  		$err = $e->getJsonBody();
		  		return $err;
			}

			return $plan;
		}

		public function existPlan( $id )
		{
			try{
				$product = \Stripe\Plan::retrieve( $id );
			} catch (Exception $e) {
		  		$err = $e->getJsonBody();
		  		$err['error']['resource_missing'];
		  		return false;
			}

			return true;
		}

		public function updatePlan( $data, $pre )
		{
			try {
				$plan = \Stripe\Plan::retrieve( $data[$pre.'-slug_name'] );
				$plan->nickname = $data[$pre.'-name'];
				$plan->trial_period_days = $data[$pre.'-trial_period_days'];
				$plan->save();
			} catch (Exception $e) {
		  		$err = $e->getJsonBody();
		  		return $err;
			}

			return $plan;
		}

		public function deletePlan ( $id )
		{
			$product = \Stripe\Plan::retrieve( $id );
			$product->delete();
		}

		public function createCustomer ( $email ){
			try {
				$customer = \Stripe\Customer::create(array(
				  "description" => "Usuario para " . $email,
				  "email" => $email
				));
			} catch (Exception $e) {
				$err = $e->getJsonBody();
				return $err;
			}

			return $customer;
		}

		public function existCustomer( $id )
		{
			try{
				$customer = \Stripe\Customer::retrieve( $id );
			} catch (Exception $e) {
		  		$err = $e->getJsonBody();
		  		$err['error']['resource_missing'];
		  		return false;
			}

			return true;
		}

	}