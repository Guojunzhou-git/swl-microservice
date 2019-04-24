<?php
namespace swlms\common\server;

class TcpServer{
    public $http_server;
    public $config;
    public function __construct($config=[], $ip='0.0.0.0', $port=8150){
        $this->config = $config;
        $this->http_server = new \swoole_server($ip, $port);
        $this->http_server->on('connect', [$this, 'onConnect']);
        $this->http_server->on('receive', [$this, 'onReceive']);
        $this->http_server->on('close', [$this, 'onClose']);
    }

    public function onConnect($server, $client){
        echo 'New tcp client connected: '.PHP_EOL;
        echo 'server: '.json_encode($server).PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo PHP_EOL;
    }

    public function onReceive($server, $client, $from_id, $data){
        echo 'A tcp client send msg to server: '.PHP_EOL;
        echo 'server: '.json_encode($server).PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo 'from_id: '.json_encode($from_id).PHP_EOL;
        echo 'data: '.json_encode($data).PHP_EOL;
        echo PHP_EOL;
        $server->send($client, 'eh, i received, waiting for callback...');
        $server->close($client);
    }

    public function onClose($server, $client){
        echo 'A tcp client disconnected: '.PHP_EOL;
        echo 'server: '.json_encode($server).PHP_EOL;
        echo 'client: '.json_encode($client).PHP_EOL;
        echo PHP_EOL;
    }

    public function startServer(){
        $this->http_server->start();
    }
}
