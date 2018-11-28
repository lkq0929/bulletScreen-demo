<?php
    /**
     * Created by PhpStorm.
     *
     * Auth: lkqlink@163.com
     * Date: 2018/11/28
     * Time: 11:44
     */
    $server = new swoole_websocket_server("127.0.0.1", 9501);
    
    
    $server->on('open', function(swoole_websocket_server $server, $request) {
        echo "server: handshake success with fd{$request->fd}\n";//$request->fd 是客户端id
    });
    
    $server->on('message', function(swoole_websocket_server $server, $frame) {
        
        $data = $frame->data; //服务端要传给客户端的数据
        foreach ($server->connections as $fd) {//$server->connections 连接的所有客户端id集合
            $server->push($fd, $data);//循环广播
        }
    });
    
    $server->on('close', function($ser, $fd) {
        echo "client {$fd} closed\n";
    });
    
    $server->start();