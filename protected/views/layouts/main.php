<?php
/* @var $this Controller */
Yii::app ()->clientScript->registerCoreScript ( 'autocomplete' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php

echo Yii::app ()->request->baseUrl;
?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php

echo Yii::app ()->request->baseUrl;
?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php

echo Yii::app ()->request->baseUrl;
?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php

echo Yii::app ()->request->baseUrl;
?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php

echo Yii::app ()->request->baseUrl;
?>/css/form.css">

	<title><?php

echo CHtml::encode ( $this->pageTitle );
?></title>
</head>

<body <?php

if (! empty ( $bodyclass ))
    echo 'class="' . $bodyclass . '"';
?>>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php

echo CHtml::encode ( Yii::app ()->name );
?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php

$this->widget ( 'zii.widgets.CMenu',
        array (
                'items' => array (
                        array (
                                'label' => 'Home',
                                'url' => array (
                                        '/site/index'
                                )
                        ),
                        array (
                                'label' => 'All People',
                                'visible' => Yii::app ()->user->isGuest,
                                'url' => array (
                                        '/person'
                                )
                        ),
                        array (
                                'label' => 'My People',
                                'visible' => ! Yii::app ()->user->isGuest,
                                'url' => array (
                                        '/person/index',
                                        'gid' => Yii::app ()->user->groupid
                                )
                        ),
						array (
                                'label' => __('Statistics'),
                                'url' => array (
                                        '/site/stats' 
                                )
                        ),
						/*array (
                                'label' => 'About',
                                'url' => array (
                                        '/site/page',
                                        'view' => 'about'
                                )
                        ),
                        array (
                                'label' => 'Contact',
                                'url' => array (
                                        '/site/contact'
                                )
                        ),*/
                        [
                                'label' => 'GitHub',
                                'url' => 'https://github.com/thevikas/genealogy'
                        ],
                        array (
                                'label' => 'Login',
                                'url' => array (
                                        '/site/login'
                                ),
                                'visible' => Yii::app ()->user->isGuest
                        ),
                        array (
                                'label' => 'Logout (' . Yii::app ()->user->name . ' G:' . Yii::app ()->user->groupid .
                                         ')',
                                        'url' => array (
                                                '/site/logout'
                                        ),
                                        'visible' => ! Yii::app ()->user->isGuest
                        )
                )
        ) );
?>
	</div><!-- mainmenu -->
	<?php

if (isset ( $this->breadcrumbs ))
:
    ?>
		<?php

    $this->widget ( 'zii.widgets.CBreadcrumbs', array (
            'links' => $this->breadcrumbs
    ) );
    ?><!-- breadcrumbs -->
	<?php endif?>









	<?php

echo $content;
?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php

echo date ( 'Y' );
?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php

echo Yii::powered ();
?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
