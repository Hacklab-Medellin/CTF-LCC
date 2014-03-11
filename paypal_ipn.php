<?php

class paypal_ipn
{
        var $paypal_post_vars;
        var $paypal_response;

        var $timeout;

        // error logging info
        var $error_log_file;
        var $error_email;

        function paypal_ipn($paypal_post_vars)
        {
                $this->paypal_post_vars = $paypal_post_vars;

                $this->timeout = 120;
        }

	function send_response()
	{
		if(extension_loaded('curl'))
			$this->send_response_curl();
		else
			$this->send_response_fsockopen();
	}

        function send_response_curl()
        {
                	// put all POST variables received from Paypal back into a URL encoded string
                        foreach($this->paypal_post_vars AS $key => $value)
                        {
                                // if magic quotes gpc is on, PHP added slashes to the values so we need
                                // to strip them before we send the data back to Paypal.
                                if( @get_magic_quotes_gpc() )
                                {
                                        $value = stripslashes($value);
                                }

                                // make an array of URL encoded values
                                $values[] = "$key" . "=" . urlencode($value);
                        }

                        // join the values together into one url encoded string
                        $this->url_string .= @implode("&", $values);

                        // add paypal cmd variable
                        $this->url_string .= "&cmd=_notify-validate";

		        $ch = curl_init();
        		curl_setopt ($ch, CURLOPT_URL, $this->url_string);
	       		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; www.iTechScripts.com; PayPal IPN Class)");
        		curl_setopt ($ch, CURLOPT_HEADER, 1);
        		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        		curl_setopt ($ch, CURLOPT_TIMEOUT, $this->timeout);
        		$this->paypal_response = curl_exec ($ch);
			curl_close($ch);

			if($this->paypal_response == "" || ($this->paypal_response != "VERIFIED" && $this->paypal_response != "INVALID"))
				$this->send_response_fsockopen();

        } // end function send_response_curl()

        // sends response back to paypal
        function send_response_fsockopen()
        {
                $fp = @fsockopen( "www.paypal.com", 80, &$errno, &$errstr, 120 );

                if( !$fp )
                {
                        $this->error_out("PHP fsockopen() error: " . $errstr);
                }

                else
                {
                        // put all POST variables received from Paypal back into a URL encoded string
                        foreach($this->paypal_post_vars AS $key => $value)
                        {
                                // if magic quotes gpc is on, PHP added slashes to the values so we need
                                // to strip them before we send the data back to Paypal.
                                if( @get_magic_quotes_gpc() )
                                {
                                        $value = stripslashes($value);
                                }

                                // make an array of URL encoded values
                                $values[] = "$key" . "=" . urlencode($value);
                        }

                        // join the values together into one url encoded string
                        $response = @implode("&", $values);

                        // add paypal cmd variable
                        $response .= "&cmd=_notify-validate";

                        fputs( $fp, "POST /cgi-bin/webscr HTTP/1.0\r\n" );
                        fputs( $fp, "Host: www.paypal.com\r\n" );
                        fputs( $fp, "User-Agent: Mozilla/4.0 (compatible; www.iTechScripts.com; PayPal IPN Class)\r\n" );
                        fputs( $fp, "Accept: */*\r\n" );
                        fputs( $fp, "Accept: image/gif\r\n" );
                        fputs( $fp, "Accept: image/x-xbitmap\r\n" );
                        fputs( $fp, "Accept: image/jpeg\r\n" );
                        fputs( $fp, "Content-type: application/x-www-form-urlencoded\r\n" );
                        fputs( $fp, "Content-length: " . strlen($response) . "\r\n\n" );

                        // send url encoded string of data
                        fputs( $fp, "$response\n\r" );
                        fputs( $fp, "\r\n" );

                        $this->send_time = time();
                        $this->paypal_response = "";

                        // get response from paypal
                        while( !feof( $fp ) )
                        {
                                $this->paypal_response .= fgets( $fp, 1024 );

                                // waited too long?
                                if( $this->send_time < time() - $this->timeout )
                                {
                                        $this->error_out("Timed out waiting for a response from PayPal. ($this->timeout seconds)");
                                }

                        } // end while

                        fclose( $fp );

                } // end else

        } // end function send_response_fsockopen()

        // returns true if paypal says the order is good, false if not
        function is_verified()
        {
                if( ereg("VERIFIED", $this->paypal_response) )
                {
                        return true;
                }
                else
                {
                        return false;
                }

        } // end function is_verified

        // returns the paypal payment status
        function get_payment_status()
        {
                return $this->paypal_post_vars['payment_status'];
        }

        // writes error to logfile, exits script
        function error_out($message)
        {

                $date = date("D M j G:i:s T Y", time());

                // add on the data we sent:
                $message .= "\n\nThe following input was received from (and sent back to) PayPal:\n\n";

                @reset($this->paypal_post_vars);
                while( @list($key,$value) = @each($this->paypal_post_vars) )
                {
                        $message .= $key . ':' . " \t$value\n";
                }

                // log to file?
                if( $this->error_log_file )
                {
                        @fopen($this->error_log_file, 'a');
                        $message = "$date\n\n" . $message . "\n\n";
                        @fputs($fp, $message);
                        @fclose($fp);
                }

                // email errors?
                if( $this->error_email )
                {
                        $additional_headers = "From: \"$fromname\" <$from>\nReply-To: $from";
                        mail($this->error_email, "[$date] paypay_ipn error", $message, $additional_headers);
                }

                exit;

        } // end function error_out

} // end class paypal_ipn

?>
