<?php
namespace frontend\modules\message\database\migrations;

use yii\db\Migration;
use yii;
class m170116_094811_add_context_field_to_message_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%message}}', 'context', $this->string());

    }

    public function down()
    {
        $this->dropColumn('{{%message}}', 'context');
    }
}
