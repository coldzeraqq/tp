<?php
namespace app\index\controller;

require VENDOR_PATH .'qiniu/php-sdk/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Index
{
    /**
     *
     */
    public function index()
    {
        // 用于签名的公钥和私钥
        $accessKey = 'tZna1OZiCUkWpeTGxUvAUaFivLdw7hlMa4';
        $secretKey = '59_UFqGM5vKzLagNfSDSiOABBteufSjpxIQmW_Oj';

        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);

        $bucket = 'Bucket_Name';
        // 生成上传Token
        $token = $auth->uploadToken($bucket);

        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        var_dump($uploadMgr);die();
    }
}
