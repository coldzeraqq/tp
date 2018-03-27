<?php
namespace app\index\controller;

use think\Controller;
use app\index\Controller\Send;
use think\Request;
use think\Response;


class Index extends  Controller
{
    use Send;

    public function __construct()
    {

    }

    public function index() {
        $result = file_get_contents("php://input");
//        var_dump($result);die();
        if(empty($result)){
            $this->returnmsg(400);
        }
        $json = json_decode($result,true);
        $results =  model("Datas")->getData($json);
        if(empty($results)){
            $this->returnmsg(500,[],[],'Internal Server Error',"Sql error","绑定失败~");
        }else{
            $this->render(200,$results);
        }

        //exit;
    }
}
