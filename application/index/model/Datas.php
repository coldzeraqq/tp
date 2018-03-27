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

    /* $param json $json
     *
     * */
    public function getData($json = ''){

        $db = db("user")->where("id",$json["uuid"])->where("name",$json["name"])->field("*")->select();
        return $db;
    }
}