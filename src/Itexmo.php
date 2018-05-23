<?php

namespace LaravelCebu\Itexmo;

class Itexmo
{
    const SEND_A_MESSAGE = 'api.php';
    const SERVER_STATUS  = 'serverstatus.php';
    const APICODE_STATUS = 'apicode_info.php';
    const DISPLAY_OUTGOING = 'display_outgoing.php';
    const DELETE_OUTGOING_ALL = 'delete_outgoing_all.php';
    const DISPLAY_MESSAGES = 'display_messages.php';

    protected $api_code;

    protected $api_base_path = 'https://www.itexmo.com/php_api/';

    protected $response;

    protected $params = [];

    public function __construct()
    {
        $this->params['apicode'] = $this->api_code = config('itexmo.api_code');
    }

    /**
     * Send a Message
     *
     * "1" = Invalid Number.
     * "2" = Number prefix not supported. Please contact us so we can add.
     * "3" = Invalid ApiCode.
     * "4" = Maximum Message per day reached. This will be reset every 12MN.
     * "5" = Maximum allowed characters for message reached.
     * "6" = System OFFLINE.
     * "7" = Expired ApiCode.
     * "8" = iTexMo Error. Please try again later.
     * "9" = Invalid Function Parameters.
     * "10" = Recipient's number is blocked due to FLOODING, message was ignored.
     * "11" = Recipient's number is blocked temporarily due to HARD sending (after 3 retries of sending and message still failed to send) and the message was ignored. Try again after an hour.
     * "12" = Invalid request. You can't set message priorities on non corporate apicodes.
     * "13" = Invalid or Not Registered Custom Sender ID.
     * "0" = Success! Message is now on queue and will be sent soon.
     *
     * @param $number
     * @param $message
     *
     * @return Itexmo
     */
    public function send($number, $message)
    {
        $this->params = ['1' => $number, '2' => $message, '3' => $this->api_code];

        return $this->curl(self::SEND_A_MESSAGE);
    }

    /**
     * Check API Service Status and your SMS Server Status
     *
     * "INVALID" = Invalid ApiCode OR "[{JSON Format}]" = JSON format of contents
     *
     * JSON Datas:
     * APIStatus: "OFFLINE" or "ONLINE"
     * DedicatedServer: "YES" or "NO"
     * GatewayNumber: Your Gateway Number
     * SMSServerStatus: "FAULTY" or "OPERATIONAL"
     *
     * @return Itexmo
     */
    public function status()
    {
        return $this->curl(self::SERVER_STATUS);
    }

    /**
     * Check ApiCode Info and Status
     *
     * "INVALID APICODE" = Invalid ApiCode OR "[{JSON Format}]" = JSON format of contents
     *
     * @return Itexmo
     */
    public function apiCodeStatus()
    {
        return $this->curl(self::APICODE_STATUS);
    }

    /**
     * Show Pending or Outgoing SMS
     *
     * "INVALID PARAMETERS" = Invalid sortby
     * "EMPTY" = No Outgoing or Pending SMS
     * "[{JSON Format}]" = JSON format of contents
     *
     * @param string $sortOrder
     *
     * @return Itexmo
     */
    public function displayOutgoing($sortOrder = 'desc')
    {
        $this->params['sortby'] = $sortOrder;

        return $this->curl(self::DISPLAY_OUTGOING);
    }

    /**
     * Delete All Pending or Outgoing SMS
     *
     * "ERROR" OR "SUCCESS"
     *
     * @return Itexmo
     */
    public function deleteOutgoingAll()
    {

        return $this->curl(self::DELETE_OUTGOING_ALL);
    }

    /**
     * @param $mode
     *
     * @return $this
     */
    private function curl($mode)
    {
        $ch = curl_init();
        $method = CURLOPT_HTTPGET;

        $query = '';
        if ($mode == self::SEND_A_MESSAGE) {
            $method = CURLOPT_POST;
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->params));
        } else {
            $query = http_build_query($this->params);
        }

        curl_setopt($ch, CURLOPT_URL, $this->api_base_path . $mode . '?' . $query);
        curl_setopt($ch, $method, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $this->response = curl_exec($ch);

        curl_close($ch);

        return $this;
    }

    /**
     * @return mixed
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->response();
    }
}
