<?php
class m170718_074741_init_db extends CDbMigration
{

    public function up()
    {
        $file = dirname ( __FILE__ ) . '/' . __CLASS__ . '.sql';
        $sql = file_get_contents ( $file );
        $this->execute ( $sql );
    }

    public function down()
    {
        echo "m170718_074741_init_db does not support migration down.\n";
        return false;
    }
}