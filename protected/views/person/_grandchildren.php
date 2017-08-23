<?php
if (count ( $data->grandchildren ))
{
    ?>
<div class="view">
	<h2>Grand children</h2>
	<ol>
<?php
    foreach ( $data->grandchildren as $child )
    {
        echo CHtml::tag ( 'li', [ ], $child->namelink );
    }
    ?>
</ol>
</div>
<?php
}
