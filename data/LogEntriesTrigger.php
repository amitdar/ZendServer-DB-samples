<?php

class LogEntriesTrigger
{

    private $execInternalPHPError;

    private function getExecInternalPHPError()
    {
        return $this->execInternalPHPError;
    }

    private function setExecInternalPHPError($execInternalPHPError)
    {
        $this->execInternalPHPError = $execInternalPHPError === 'y' ? false : true;
    }

    public function triggerUserError($logEntryText, $userErrorType)
    {
        if ($this->verifyErrorNumber($userErrorType)) {
            if (is_array($logEntryText)) {
            	trigger_error(print_r($logEntryText, TRUE), $userErrorType);
                return;
            }
            trigger_error($logEntryText, $userErrorType);
        }
    }

    public function customUserError($logEntryText, $userErrorType, $execInternalPHPError)
    {
        $this->setExecInternalPHPError($execInternalPHPError);
        set_error_handler(array(
            $this,
            'userErrorHandler'
        ), E_ALL);
        $this->triggerUserError($logEntryText, $userErrorType);
    }
    
    public function arrayUserError($arrayContent, $userErrorType){
    	$this->triggerUserError(explode("*", $arrayContent), $userErrorType);
    }

    public function triggerErrorEntry()
    {
        foo();
    }

    public function triggerNoticeEntry()
    {
        echo $arr[0];
    }

    public function tirggerWarningEntry()
    {
        file_get_contents("someFile");
    }

    private function userErrorHandler($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) {
            case E_USER_ERROR:
                echo json_encode(array(
                    'customUserErrorTirgger' => E_USER_ERROR,
                    'errorMsg' => $errstr
                ));
                break;
            case E_USER_WARNING:
                echo json_encode(array(
                    'customUserErrorTirgger' => E_USER_WARNING,
                    'errorMsg' => $errstr
                ));
                break;
            case E_USER_NOTICE:
                echo json_encode(array(
                    'customUserErrorTirgger' => E_USER_NOTICE,
                    'errorMsg' => $errstr
                ));
                break;
            case E_DEPRECATED:
            	echo "asfdsadf";
            	break;
        }
        return $this->getExecInternalPHPError();
    }

    private function verifyErrorNumber($x)
    {
        if ((($x - 1) & $x) == 0)
            return true;
        return false;
    }
}


