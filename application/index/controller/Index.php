<?php
namespace app\index\controller;

use think\Controller;
use app\index\Controller\Send;
use think\Request;
use think\Response;


class Index extends  Controller
{
    use Send;

    public function index() {
        echo 'merge1313131';
        $result = file_get_contents("php://input");
//        var_dump($result);die();
        if(empty($result)){
            $this->returnmsg(400);
        }
        $json = json_decode($result,true);
        $results =  model("Datas")->getData($json);
//        var_dump($results);die();
        if(!$results){
            return self::returnmsg(500,[],[],'Internal Server Error',"Sql error","更新失败~");
        }else{
            return self::render(200,$results);
        }

        //exit;
    }
}
