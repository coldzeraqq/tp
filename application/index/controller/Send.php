<?php
/**
 * 向客户端发送相应基类
 */
namespace app\index\controller;

use think\Response;
use think\response\Redirect;

trait Send
{

    /**
     * 默认返回资源类型
     * @var string
     */
    protected $restDefaultType = 'json';

    /**
     * 设置响应类型
     * @param null $type
     * @return $this
     */
    public function setType($type = null)
    {
        $this->type = (string)(!empty($type)) ? $type : $this->restDefaultType;
        return $this;
    }

    /**
     * 失败响应
     * @param int $error
     * @param string $message
     * @param int $code
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     */
    public function sendError($error = 400, $message = 'error', $code = 400, $data = [], $headers = [], $options = [])
    {
        $responseData['error'] = (int)$error;
        $responseData['message'] = (string)$message;
        if (!empty($data)) $responseData['data'] = $data;
        $responseData = array_merge($responseData, $options);
        return $this->response($responseData, $code, $headers);
    }

    /**
     * 成功响应
     * @param array $data
     * @param string $message
     * @param int $code
     * @param array $headers
     * @param array $options
     * @return Response|\think\response\Json|\think\response\Jsonp|Redirect|\think\response\Xml
     */
    public function render($code, $result = '')
    {

        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers:token,content-type');
        // 组合返回数据
        http_response_code($code);
        session_start();
        if (is_array($result)) {
            foreach ((array)$result as $name => $data) {
                // (array)强制转化，增强程序的健壮性
                if (strpos($name, '.list')) {
                    // strrpos() - 查找字符串在另一字符串中最后一次出现的位置（区分大小写）
                    $model = trim(str_replace('.list', '', $name));
                    // 替换函数
                    foreach ((array)$data as $key => $value) {
                        $result[$name][$key] = $value;
                    }
                } else {
                    $model = trim($name);
                    $result[$name] = $data;
                }
            }
        }
        // 输出中文字符的时候会进行json格式转码
        echo json_encode(
            $result
            ,JSON_UNESCAPED_UNICODE);
        $result = null;
        unset($result);
        ob_flush();
        flush();
        session_destroy();
        exit();
    }

    public function sendSuccess($data = [], $code = 200, $headers = [], $options = [])
    {
//        var_dump($data);die;
//        $responseData['error'] = 0;
//        $responseData['message'] = (string)$message;
        if(empty($data)) $responseData['data']="";
        if (!empty($data)) $responseData['data'] = $data;
            $responseData = array_merge($responseData, $options);
        return $this->response($responseData, $code, $headers);
    }

    /**
     * 重定向
     * @param $url
     * @param array $params
     * @param int $code
     * @param array $with
     * @return Redirect
     */
    public function sendRedirect($url, $params = [], $code = 302, $with = [])
    {
        $response = new Redirect($url);
        if (is_integer($params)) {
            $code = $params;
            $params = [];
        }
        $response->code($code)->params($params)->with($with);
        return $response;
    }

    /**
     * 响应
     * @param $responseData
     * @param $code
     * @param $headers
     * @return Response|\think\response\Json|\think\response\Jsonp|Redirect|\think\response\View|\think\response\Xml
     */
    public function response($responseData, $code, $headers)
    {
        if (!isset($this->type) || empty($this->type)) $this->setType();
        return Response::create($responseData, $this->type, $code, $headers);
    }

    /**
     * 如果需要允许跨域请求，请在记录处理跨域options请求问题，并且返回200，以便后续请求，这里需要返回几个头部。。
     * @param code 状态码
     * @param message 返回信息
     * @param data 返回信息
     * @param header 返回头部信息
     */
    public function returnmsg($code = '400',$data = [],$header = [],$type="",$reason="",$message="")
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers:token,content-type');
    	http_response_code($code);    //设置返回头部
        if($code==400){
            $error['error']['type'] = "BAD_REQUEST";
            $error['error']['reason'] = "param missing";
            $error['error']['message'] = "请求体不完整";
//    	$error['error'] = $message;
            if (!empty($data)) $error['error']['data'] = $data;
            // 发送头部信息
            foreach ($header as $name => $val) {
                if (is_null($val)) {
                    header($name);
                } else {
                    header($name . ':' . $val);
                }
            }

        }elseif($code==401){
            $error['error']['type'] = "AUTH_ERROR";
            $error['error']['reason'] = "token error.";
            $error['error']['message'] = "鉴权失败";
//    	$error['error'] = $message;
            if (!empty($data)) $error['error']['data'] = $data;
            // 发送头部信息
            foreach ($header as $name => $val) {
                if (is_null($val)) {
                    header($name);
                } else {
                    header($name . ':' . $val);
                }
            }

    }elseif($code==402){
            //自定义
            $error['error']['type'] = $type;
            $error['error']['reason'] = $reason;
            $error['error']['message'] = $message;
//    	$error['error'] = $message;
            if (!empty($data)) $error['error']['data'] = $data;
            // 发送头部信息
            foreach ($header as $name => $val) {
                if (is_null($val)) {
                    header($name);
                } else {
                    header($name . ':' . $val);
                }
            }
        }elseif($code==403){
//        var_dump($code);die;
            //自定义
            $error['error']['type'] = $type;
            $error['error']['reason'] = $reason;
            $error['error']['message'] = $message;
//    	$error['error'] = $message;
            if (!empty($data)) $error['error']['data'] = $data;
            // 发送头部信息
            foreach ($header as $name => $val) {
                if (is_null($val)) {
                    header($name);
                } else {
                    header($name . ':' . $val);
                }
            }
        }elseif($code==404){
            $error['error']['type'] = "NOT_FOUND";
            $error['error']['reason'] = "url error.";
            $error['error']['message'] = "请求资源不存在";
//    	$error['error'] = $message;
            if (!empty($data)) $error['error']['data'] = $data;
            // 发送头部信息
            foreach ($header as $name => $val) {
                if (is_null($val)) {
                    header($name);
                } else {
                    header($name . ':' . $val);
                }
            }

        }elseif($code==500){
            //
            $error['error']['type'] = "Internal Server Error";
            $error['error']['reason']=$reason;
            $error['error']['message'] = $message;
//    	$error['error'] = $message;
            if (!empty($data)) $error['error']['data'] = $data;
            // 发送头部信息
            foreach ($header as $name => $val) {
                if (is_null($val)) {
                    header($name);
                } else {
                    header($name . ':' . $val);
                }
            }
        }elseif($code==405){
            $error['error']['reason']="Method Not Allowed ";
              $error['error']['message'] = "资源请求类型有误";
                foreach ($header as $name => $val) {
                    if (is_null($val)) {
                        header($name);
                    } else {
                        header($name . ':' . $val);
                    }
                }
        }


    	exit(json_encode($error,JSON_UNESCAPED_UNICODE));
    }
}