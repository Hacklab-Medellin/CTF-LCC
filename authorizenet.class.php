<?php

function addArray(&$array, $key, $from_array, $from_array_key) {
        if(array_key_exists($key, $array)) {
                if(array_key_exists($from_array_key, $from_array)) {
                        $array[$key] = $from_array[$from_array_key];
                }
                else {
                        $array[$key] = "";
                }
        }
        else {
                if(array_key_exists($from_array_key, $from_array)) {
                        $array = array_merge($array, array($key => $from_array[$from_array_key]));
                }
                else {
                        $array[$key] = "";
                }
        }
}

function addArraySimple(&$array, $key, $value) {
        if(array_key_exists($key, $array)) {
                $array[$key] = $value;
        }
        else {
                $array = array_merge($array, array($key => $value));
        }
}

class payment_authorizenet
{
	var $x_login, $x_tran_key;
	var $x_version = 3.1;
	var $x_delim_data = "true", $x_delim_char = "&";
	var $x_relay_response = "false", $x_test_request;
	var $timeout = "60";
	var $__customer_billing_data = array(), $__customer_shipping_data = array();
	var $x_cust_id, $x_customer_ip;
	var $x_email_customer, $x_merchant_email;
	var $x_invoice_num, $x_description, $x_amount;
	var $x_method, $x_recurring_billing, $x_currency_code;
	var $__payment_data = array(), $__response_data, $__response_array = array();
	var $__post_array = array();
	var $transaction_good;
	var $transaction_error_msg;
	var $response_code, $response_subcode, $response_reason_code, $response_reason_text;
	var $approval_code, $avs_result_code, $card_code_response_code;
	
	// authorize.net specific functions for payment processing
	
	function payment_authorizenet(&$constructor) {
		foreach($constructor as $key=>$value) {
			$varname = "x_" . $key;
			@$this->$varname = $value;
		}
	}
	
	function addCustomerInfo(&$customer_info, $info_type) {
		$var_prefix = ($info_type == "shipping") ? "x_ship_to_" : "x_";
		$array_name = "__customer_" . (($info_type == "shipping" || $info_type == "billing") ? $info_type : "billing") . "_data";
		foreach($customer_info as $key=>$value) {
			$varname = $var_prefix . $key;
			if(!is_numeric($key)) {
				if($info_type == "billing") {
					$this->__customer_billing_data[$varname] = $value;
				}
				elseif($info_type == "shipping") {
					$this->__customer_shipping_data[$varname] = $value;
				}
			}
		}
	}
	
	function doPayment($invoice_num, $description, $amount, $recurring, &$processor_vars) {
		@$this->x_invoice_num = $invoice_num;
		@$this->x_description = $description;
		@$this->x_amount = $amount;
		addArray($this->__payment_data, "x_po_num", $processor_vars, "po_num");
		addArray($this->__payment_data, "x_tax", $processor_vars, "tax");
		addArray($this->__payment_data, "x_tax_exempt", $processor_vars, "tax_exempt");
		addArray($this->__payment_data, "x_freight", $processor_vars, "freight");
		addArray($this->__payment_data, "x_duty", $processor_vars, "duty");
		addArraySimple($this->__payment_data, "x_recurring_billing", $recurring);
		if($this->x_method == "cc") {
			addArray($this->__payment_data, "x_card_num", $processor_vars, "card_num");
			addArray($this->__payment_data, "x_exp_date", $processor_vars, "exp_date");
			addArray($this->__payment_data, "x_card_code", $processor_vars, "card_code");
			addArray($this->__payment_data, "x_type", $processor_vars, "charge_type");
			addArray($this->__payment_data, "x_trans_id", $processor_vars, "trans_id");
			addArray($this->__payment_data, "x_auth_code", $processor_vars, "auth_code");
		}
		elseif($this->x_method == "echeck") {
			addArraySimple($this->__payment_data, "x_echeck_type", "WEB");
			addArray($this->__payment_data, "x_bank_aba_code", $processor_vars, "bank_aba_code");
			addArray($this->__payment_data, "x_bank_acct_num", $processor_vars, "bank_acct_num");
			addArray($this->__payment_data, "x_bank_acct_type", $processor_vars, "bank_acct_type");
			addArray($this->__payment_data, "x_bank_acct_name", $processor_vars, "bank_acct_name");
			addArray($this->__payment_data, "x_bank_name", $processor_vars, "bank_name");
		}
		
		$object_vars = get_object_vars($this);
		$this->__addPostArray($object_vars);
		$this->__addPostArray($this->__customer_billing_data);
		$this->__addPostArray($this->__customer_shipping_data);
		$this->__addPostArray($this->__payment_data);
		
		// join the values together into one url encoded string
		$post_string = "";
		foreach($this->__post_array as $key=>$value) {
			$post_string .= "&" . $key . "=" . $value;
		}
		$post_data = substr($post_string, 1);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://secure.authorize.net/gateway/transact.dll");
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; www.iTechScripts.com; Developer - Jeremy Johnstone)");
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		$this->__response_data = curl_exec ($ch);
		curl_close($ch);
		
		return $this->receiveResponseData();
	}
	
	function receiveResponseData($http_response_data = "") {
		if($http_response_data != "" && $this->__response_data == "") {
			$this->__response_data = $http_response_data;
		}
		$this->__response_array = explode(",", $this->__response_data);
		
		$this->response_code = $this->__response_array[0];
		$this->response_subcode = $this->__response_array[1];
		$this->response_reason_code = $this->__response_array[2];
		$this->response_reason_text = $this->__response_array[3];
		$this->appoval_code = $this->__response_array[4];
		$this->avs_result_code = $this->__response_array[5];
		$this->card_code_response_code = $this->__response_array[39];
		
		if($this->response_code == 1) {
			$this->transaction_good = TRUE;
		}
		elseif($this->response_code > 1) {
			$this->transaction_error_msg = "[Error #" . $this->response_code . "." . $this->response_subcode . "." . $this->response_reason_code . "]: " . $this->response_reason_text;
			$this->transaction_good = FALSE;
		}
		
		return $this->transaction_good;

	}	
	
	function enableCustomerEmails($boolean) {
		$this->x_email_customer = $boolean;
	}
	
	function testMode($boolean) {
		$this->x_test_request = $boolean;
	}
	
	function setMerchantAddress($merchant_email) {
		$this->x_merchant_email = $merchant_email;
	}
	
	function setCustomerIP($customer_ip) {
		$this->x_customer_ip = $customer_ip;
	}
	
	function __addPostArray($data) {
		foreach($data as $key=>$value) {
			if(substr($key, 0, 2) == "x_")
			if(!is_null($value)) $this->__post_array[$key] = $value;
		}
	}
	
	function error_msg($display_level) {
		switch($this->response_code) {
			case 1: return "Transaction was appoved.";
			case 2: return "Transaction was declined.";
			case 3: return "A system error occured. Please contact support.";
		}
	}
	
}

?>
