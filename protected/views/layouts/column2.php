<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
		
		
		$this->beginWidget('zii.widgets.CPortlet', array(
		        'title'=>__('Recent People'),
		));
		
		$this->widget('zii.widgets.CMenu', array(
		        'items'=>Controller::recentpersons(),
		        //'title'=>'Recent Persons',
		));
		
		
		$this->endWidget();
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>