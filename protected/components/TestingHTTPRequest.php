<?php
class TestingHTTPRequest extends CHttpRequest
{
    public function redirect($url,$terminate=true,$statusCode=302)
    {
        global $redirect_url,$redirect_status;
        $redirect_status = $statusCode;
        $redirect_url = $url;
    }

}

