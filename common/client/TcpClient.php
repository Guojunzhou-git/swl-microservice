<?php
namespace swlms\common\client;

class TcpClient{
    public $ip;
    public $port;
    public $tcp_client;
    public function __construct($ip='127.0.0.1', $port=8150){
        $this->ip = $ip;
        $this->port = $port;
        $this->tcp_client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->tcp_client->on('connect', [$this, 'onConnect']);
        $this->tcp_client->on('receive', [$this, 'onReceive']);
        $this->tcp_client->on('error', [$this, 'onError']);
        $this->tcp_client->on('close', [$this, 'onClose']);
    }

    public function onConnect($client){
        echo 'This client connected: '.PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo PHP_EOL;
        $client->send(json_encode([
            'action' => '/config/regist',
            'service_ip' => '127.0.0.1',
            'service_port' => 100001,
            'dependence' => [],
        ]));
    }

    public function onReceive($client, $data){
        echo 'This client receive msg from server: '.PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo 'data: '.$data.PHP_EOL;
        echo PHP_EOL;
    }

    public function onError($client){
        echo 'This client occured an error: '.PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo PHP_EOL;
    }

    public function onClose($client){
        echo 'This client disconnected: '.PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo PHP_EOL;
    }

    public function connect(){
        $this->tcp_client->connect($this->ip, $this->port, 1);
    }
}
