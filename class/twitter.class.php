<?php
/**
 * Update the status of a twitter user
 *
 * @package ANECMS
 * @author Felix Oghina <znupi69@gmail.com>
 * @version 1.0
 */

/**
 * Update the status of a twitter user
 *
 * @author Felix Oghina <znupi69@gmail.com>
 * @version 1.0
 */
class Twitter {

    /**
     * Auth name and password for twitter
     *
     * @var string
     */
    private $auth = false;

    /**
     * Debug or not
     *
     * @var boolean
     */
    private $debug = false;

    /**
     * Error with twitter post
     *
     * @var string
     */
    public  $error = false;

    /**
     * Constructor initialize variables
     *
     * @param string $user Username of Twitter
     * @param string $pass Password of Twitter
     * @param boolean $debug
     */
    public function __construct($user, $pass, $debug=false) {
        // Store an auth key for the HTTP Authorization: header
        $this->auth = base64_encode($user . ':' . $pass);
        $this->debug = $debug;
    }

    /**
     *
     * @param string $new_status New status for Twitter
     * @return boolean
     */
    public function update($new_status) {
        if (strlen($new_status) > 140) {
            $this->error = "Status too long: {$new_status}.";
            return false;
        }
        $fp = @fsockopen('twitter.com', 80, $errno, $errstr);
        if (!$fp) {
            $this->error = "Socket error #{$errno}: {$errstr}";
            return false;
        }
        $post_data = "status=" . urlencode($new_status);
        $to_send  = "POST /statuses/update.xml HTTP/1.1\r\n";
        $to_send .= "Host: twitter.com\r\n";
        $to_send .= "Content-Length: " . strlen($post_data) . "\r\n";
        $to_send .= "Authorization: Basic {$this->auth}\r\n\r\n";
        $to_send .= $post_data . "\r\n\r\n";
        $bytes = fwrite($fp, $to_send);
        if ($bytes === false) {
            $this->error = "Socket error: Error sending data.";
            return false;
        }
        elseif ($bytes < strlen($to_send)) {
            $this->error = "Socket error: Could not send all data.";
            return false;
        }
        if ($this->debug) echo "Sent:\n{$to_send}\n\n";
        $response = '';
        while (!feof($fp)) {
            $buf = fread($fp, 1024);
            if ($buf === false) {
                $this->error = "Socket error: Error reading data.";
                return false;
            }
            $response .= $buf;
        }
        if ($this->debug) echo "Received:\n{$response}";
        $was_error = preg_match(
                "#" .
                preg_quote("<error>") .
                "(.+)" .
                preg_quote("</error>") .
                "#i",
                $response, $matches);
        if ($was_error) {
            $this->error = "Twitter error: {$matches[1]}";
            return false;
        }
        list($first_line) = explode("\r\n", $response);
        if ($first_line != "HTTP/1.1 200 OK") {
            $this->error = "Request error: {$first_line}";
            return false;
        }
        return true;
    }
}
?>