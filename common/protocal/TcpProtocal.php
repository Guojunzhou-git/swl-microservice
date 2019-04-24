<?php
namespace swlms\common\protocal;

class TcpProtocal extends Protocal{
    public $action;
    public $service_ip;
    public $service_port;
    public $dependence;
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
        $this->service_ip = $this->_data['service_ip'];
        $this->service_port = $this->_data['service_port'];
        $this->dependence = $this->_data['dependence'];
    }

    public function setVerifyRules(){
        $this->_verify_rules = [
            'action' => 'required|string|[up-regist,down-notify]',
            'service_ip' => 'required|string|ip',
            'service_port' => 'required|integer|[0-65535]',
            'dependence' => 'required|array',
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