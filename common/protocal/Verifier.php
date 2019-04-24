<?php
namespace swlms\common\protocal;

use Ramsey\Uuid\Uuid;

class Verifier{
    private $_rules;
    private $_errors = [];
    public function __construct($rules=[]){
        $this->_rules = $rules;
    }

    public function verify($data){
        $pass = true;
        foreach ($this->_rules as $verify_item => $verify_rule) {
            @list($frequence, $value_type, $value_scope) = explode('|', $verify_rule);
            $verify_item_value = isset($data[$verify_item]) ? $data[$verify_item] : false;
            if(!$this->_verifyFrequenct($frequence, $verify_item_value)){
                $pass = false;
                array_push($this->_errors, [$verify_item, 'frequence verify error: '.$frequence]);
            }
            if(!$this->_verifyType($value_type, $verify_item_value)){
                $pass = false;
                array_push($this->_errors, [$verify_item, 'value_type verify error: '.$value_type]);
            }
            if(!$this->_verifyScope($value_scope, $verify_item_value)){
                $pass = false;
                array_push($this->_errors, [$verify_item, 'value_scope verify error: '.$value_scope]);
            }
        }
        return $pass;
    }

    public function getErrors(){
        return $this->_errors;
    }

    private function _verifyFrequenct($frequence, $data=false){
        if($frequence == 'required' && !$data){
            return false;
        }
        return true;
    }

    private function _verifyType($type, $data=false){
        if($type == 'array' && !is_array($data)){
            return false;
        }
        if($type == 'string' && !is_string($data)){
            return false;
        }
        if(in_array($type, ['int', 'integer']) && !is_integer($data)){
            return false;
        }
        if($type == 'float' && !is_float($data)){
            return false;
        }
        return true;
    }

    private function _verifyScope($scope, $data=false){
        if($scope == 'uuid1'){
            try{
                $uuid = Uuid::fromString($data);
                $uuid_datetime = $uuid->getDateTime();
                if(!$uuid_datetime){
                    return false;
                }
            }catch (\Exception $e){
                return false;
            }
        }
        $range_start_pos = stripos('[', $scope);
        $range_end_post = stripos(']', $scope);
        if(false !== $range_start_pos && false !== $range_end_post){
            $scope_range_string = substr($scope, $range_start_pos+1, $range_end_post-1);
            if(false !== stripos(',', $scope_range_string)){
                $scope_range = explode(',', $scope_range_string);
                if(!in_array($data, $scope_range)){
                    return false;
                }
            }
            if(false !== stripos('-', $scope_range_string)){
                $scope_range = explode('-', $scope_range_string);
                $scope_range_min = $scope_range[0];
                $scope_range_max = $scope_range[1];
                if($data < $scope_range_min || $data > $scope_range_max){
                    return false;
                }
            }
        }
        return true;
    }
}