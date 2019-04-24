<?php
namespace swlms\common\protocal;
use swlms\common\iface\ProtocalInterface;

class HttpProtocal implements ProtocalInterface{
    public $action;
    public $data;
    public $request_id;
    public $request_microtime;
    public $debug;
    private $_verify_rules;
    private $_verifier;
    private $_data;
    private $_verify_errors;

    public function __construct(){
        $this->setVerifyRules();
        $this->_verifier = new Verifier($this->_verify_rules);
    }

    public function load(){
        $this->action = $this->_data['action'];
        $this->data = $this->_data['data'];
        $this->request_id = $this->_data['request_id'];
        $this->request_microtime = $this->_data['request_microtime'];
        $this->debug = $this->_data['debug'];
    }

    final public function setVerifyRules(){
        $this->_verify_rules = [
            'action' => 'required|string',
            'data' => 'sometimes|array',
            'request_id' => 'required|string|uuid1',
            'request_microtime' => 'required|string',
            'debug' => 'required|string|[0,1]',
        ];
    }

    public function verify($data=[]){
        if($this->_verifier->verify($data)){
            $this->_data = $data;
            return true;
        }else{
            $this->_verify_errors = $this->_verifier->getErrors();
            return false;
        }
    }

    public function getErrors(){
        return $this->_verify_errors;
    }
}