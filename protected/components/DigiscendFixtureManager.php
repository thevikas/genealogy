<?php
use Aura\Html\Exception;

Yii::import('system.test.CDbFixtureManager');
class DigiscendFixtureManager extends CDbFixtureManager
{
    public function load($tables)
    {
        $allsql = '';
        foreach ( $tables as $table )
        {
            if ($table [0] == ':')
                $filename = substr ( $table, 1 );
            else
            {
                $m = new $table ();
                $filename = $m->tableName ();
            }
            $mats = [];
            if(preg_match('/(?<table>[a-zA-Z0-0_]+)$/', $filename,$mats))
                $filename = $mats['table'];
            $dir = realpath ( __DIR__ . '/../tests/fixtures' );
            $filepath = $dir . '/' . $filename . '.sql';
            //error_log("fixture = $filepath");
            if(!file_exists ( $filepath ))
            {
                throw new Exception("$filepath was not found for $table" );
            }
            $sql = file_get_contents ( $filepath );
            if(empty($sql))
                throw new Exception("$filepath is empty for $table" );

            $allsql .= $sql;

        }

        $allsql = "SET FOREIGN_KEY_CHECKS=0;\n" . $allsql . "SET FOREIGN_KEY_CHECKS=1;\n";
        try {
            $rows = Yii::app ()->db->createCommand ( $allsql )->execute();
            $rows2 = Yii::app ()->db->createCommand ( 'SELECT ROW_COUNT();' )->execute ();
            //print_r($rows2);
        }
        catch (Exception $e)
        {
            die("fixture exception-" . $e->getMessage());
        }
        if($rows2 == 0)
        {
            file_put_contents(__DIR__ . '/../tests/last_fixture.sql', $allsql);
            throw new \Exception("fixtures failed! check last_fixture.sql");
        }
        error_log("fixture rows=$rows, $rows2");
    }

    public function loadall()
    {
        $dir = realpath ( __DIR__ . '/../tests/fixtures' );
        $dh = opendir($dir);
        $allsql = '';
        while ( $filename = readdir($dh) )
        {
            if(!preg_match('/\.sql$/',$filename))
                continue;

            $filepath = $dir . '/' . $filename;
            $sql = file_get_contents ( $filepath );
            if (empty ( $sql ))
                throw new Exception ( "$filepath is empty" );

            $allsql .= $sql;
        }

        $allsql = "SET FOREIGN_KEY_CHECKS=0;\n" . $allsql . "SET FOREIGN_KEY_CHECKS=1;\n";
        $rows = Yii::app ()->db->createCommand ( $allsql )->execute ();
    }
}
