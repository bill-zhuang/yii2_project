<?php


namespace common\helpers;

use Yii;
use yii\web\UploadedFile;


/**
 * Usage:
 * $uploadObj = UploadedFile::getInstanceByName("upload_name");
 * $localUpload = new UploadLocal();
 * $localUpload->fileobj = $uploadObj;
 * $ret = $ossUpload->uploadLocal();
 *
 * Class UploadLocal
 * @package common\helpers
 */
class UploadLocal
{
    const UPLOAD_DIRNAME = 'upload';

    /**
     * @var UploadedFile
     */
    public $fileobj;

    public function uploadLocal()
    {
        if (!$this->fileobj) {
            return false;
        }
        $filePutPath = md5(date('YmdHis') . $this->fileobj->getBaseName())
            . '.' . $this->fileobj->getExtension();
        //
        $uploadInfo = array();
        try {
            $moveDir = Yii::$app->basePath . '/web/' . self::UPLOAD_DIRNAME . '/';
            if (!file_exists($moveDir)) {
                mkdir($moveDir, 0777, true);
            }
            $ret = move_uploaded_file($this->fileobj->tempName, $moveDir . $filePutPath);
            //chmod($moveDir . $filePutPath, 755);
            if ($ret) {
                $uploadInfo['info']['url'] = $filePutPath;
            }
        } catch (\Exception $e) {
            //\Yii::error($e->getMessage());
            return '';
        }

        return $uploadInfo;
    }
}