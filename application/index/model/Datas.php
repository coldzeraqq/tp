<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 16:32
 */

namespace app\index\model;
use think\Model;
use think\Db;

class Datas extends Model
{
    public function getData($json = ''){

        $db = db("user")->where("id",$json["uuid"])->update(["name"=>"rain"]);
//        var_dump($db);die();
        return $db;
    }
}