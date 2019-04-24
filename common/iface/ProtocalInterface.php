<?php
namespace swlms\common\iface;

interface ProtocalInterface{
    public function load();

    public function setVerifyRules();

    public function verify($data=[]);

    public function getErrors();
}
