<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Response;
use app\index\Send;

class Index extends  Controller
{
    public function index() {
        $result = file_get_contents("php://input");
//        var_dump($result);die();
        /*if(empty($result)){
            echo 101;
            return;
        }*/
        $json = json_decode($result,true);
        $result =  model("Datas")->getData($json);
        $this->returnmsg(500,[],[],'Internal Server Error',"Sql error","绑定失败~");
        //exit;
    }
}
