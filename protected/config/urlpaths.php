<?php
return array (
                        'urlFormat' => 'path',
                        'rules' => array (
                                '<controller:api>/<action:uploadkey>/<id_project:\d+>/<id_person:\d+>' => '<controller>/<action>',
                                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                                '<controller:\w+>/<key2:\w+>/<id2:\d+>/<action:\w+>' => '<controller>/<action>',
                                '<controller:api>/<action:upload>/<ukey:\w+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>' => '<controller>/<action>' 
                        ) 
                );