<?php
return CMap::mergeArray ( require (dirname ( __FILE__ ) . '/main.php'), 
        array (
                'components' => array (
                        'fixture' => array (
                                'class' => 'system.test.CDbFixtureManager' 
                        ),
                        'db' => array (
                                'connectionString' => 'mysql:host=localhost;dbname=tasker_testing',
                                'emulatePrepare' => true,
                                'username' => 'root',
                                'password' => '',
                                'charset' => 'utf8',
                                'schemaCachingDuration' => 60 * 60 
                        ),
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
		) 
        ) );
