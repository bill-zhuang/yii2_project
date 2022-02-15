<?php

namespace backend\models;


class User extends \common\models\User
{
    /**
     * @param $password
     * @return bool
     * @throws \yii\base\Exception
     */
    public function resetPassword($password)
    {
        $this->setPassword($password);
        $this->generateAuthKey();
        $this->generatePasswordResetToken();
        $this->updated_at = time();
        return $this->save();
    }

    public function deleteUser()
    {
        $this->username = $this->username . '_'  .$this->id;
        $this->status = User::STATUS_DELETED;
        $this->updated_at = time();
        return $this->save();
    }
}