<?php
if (count ( $data->greatgrandchildren))
{
    ?>
<div class="view">
	<h2>Great Grand children</h2>
	<ol>
<?php
    foreach ( $data->greatgrandchildren as $child )
    {
        echo CHtml::tag ( 'li', [ ], $child->namelink );
    }
    ?>
</ol>
</div>
<?php
}
