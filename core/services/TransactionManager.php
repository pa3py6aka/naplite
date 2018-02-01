<?php

namespace core\services;


class TransactionManager
{
    public function wrap(callable $function)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $result = $function();
            $transaction->commit();
            return $result;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}