<?php
class m170718_103301_add_group_field extends CDbMigration
{

    public function up()
    {
        $this->execute ( 
                "
                ALTER TABLE `marriages` ADD `owner_gid` INT NOT NULL DEFAULT '1' COMMENT 'Owner group id' AFTER `wife_cid`;
                ALTER TABLE `persons` ADD `owner_gid` INT NOT NULL DEFAULT '1' COMMENT 'Owner group id' AFTER `cid`;
            " );
    }

    public function down()
    {
        echo "m170718_103301_add_group_field does not support migration down.\n";
        return false;
    }
}