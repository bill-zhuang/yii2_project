<?php


namespace common\helpers;

use Yii;
use OSS\OssClient;
use yii\web\UploadedFile;


class UploadOss
{
    const UPLOAD_DIRNAME = '';//TODO upload dir

    private $access_key_id;
    private $access_key_secret;
    private $bucket;
    private $end_point;

    private $client;
    /**
     * @var UploadedFile
     */
    public $fileobj;

    public function __construct()
    {
        $paramsOss = Yii::$app->params['aliyun_oss'];
        $this->access_key_id = $paramsOss['access_key'];
        $this->access_key_secret = $paramsOss['access_key_secret'];
        $this->bucket = $paramsOss['bucket'];
        $this->end_point = $paramsOss['end-point'];
        //
        $this->client = new OssClient($this->access_key_id, $this->access_key_secret, $this->end_point);
        //$this->client->createBucket($this->bucket, OssClient::OSS_ACL_TYPE_PUBLIC_READ);
    }

    public function uploadOss()
    {
        if (!$this->fileobj) {
            return false;
        }
        $this->fileobj->fullPath;
        $filePutPath = self::UPLOAD_DIRNAME . '/'
            . md5(date('YmdHis') . $this->fileobj->getBaseName())
            . '.' . $this->fileobj->getExtension();
        //
        try {
            $uploadInfo = $this->client->uploadFile($this->bucket, $filePutPath, $this->fileobj->tempName);
        } catch (\Exception $e) {
            return '';
        }

        return $uploadInfo;
    }

    public function deleteOss($objname)
    {
        try {
            $this->client->deleteObject($this->bucket, $objname);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function getList()
    {
        $listObjectInfo = $this->client->listObjects($this->bucket,
            ['max-keys' => 5, 'prefix' => self::UPLOAD_DIRNAME . '/', 'delimiter' => '',]);
        $objectList = $listObjectInfo->getObjectList();
        foreach ($objectList as $key => $value) {
            echo '<pre>';
            print_r($value);
            exit;
        }
    }
}