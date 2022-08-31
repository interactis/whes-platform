<?php

use yii\db\Migration;
use common\models\Supplier;
use common\models\Content;

/**
 * Class m220831_124916_suppliers
 */
class m220831_124916_suppliers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$suppliers = Supplier::find()->orderBy('id')->all();
		
		foreach ($suppliers as $supplier)
		{
			$content = $this->_findContent($supplier->content_id);
			if ($content)
			{
				$content->supplier_id = $supplier->id;
				$content->save();	
			}
		}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220831_124916_suppliers cannot be reverted.\n";

        return false;
    }
	
	
	private function _findContent($id)
    {        
		return Content::find()
			->where(['id' => $id])
			->one();
    }
}
