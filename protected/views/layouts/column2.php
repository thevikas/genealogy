<?php
/* @var $this Controller */
?>
<?php
Yii::app()->clientScript->registerCoreScript('font-awesome');
$this->beginContent ( '//layouts/main' );
?>
<div class="span-19">
	<div id="content">
		<?php

echo $content;
?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<?php
echo $this->renderPartial ( '//layouts/_quicksearch' );

$this->beginWidget ( 'zii.widgets.CPortlet', array (
        'title' => 'Operations'
) );

$this->widget ( 'zii.widgets.CMenu',
        array (
                'items' => $this->menu,
                'htmlOptions' => array (
                        'class' => 'operations'
                )
        ) );
$this->endWidget ();

$this->beginWidget ( 'zii.widgets.CPortlet', array (
        'title' => CHtml::link(__( 'Recent People' ) ,['person/index','mru' => 1])
) );

$this->widget ( 'zii.widgets.CMenu',
        array (
                'items' => Controller::recentpersons ()
            // 'title'=>'Recent Persons',
        ) );

$this->endWidget ();
?>
	</div><!-- sidebar -->
</div>
<?php

$this->endContent ();
?>
