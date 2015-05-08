<div class="span9">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/javascripts/graphDemo.js"></script>

 <input type="hidden" id="url" value="<?php echo $this->createUrl("room/del") ?>">
<h4 class="page-title">房间分类</h4>
 <div id="widget" class="block-body collapse in">
    <table class="table">
      <tbody>
        
			<th>分类名称</th>
			<th>显示</th>
			<th>排序</th>
			<th>操作</th>
		
      </tbody>
    </table>
</div>
<?php foreach($parent as $v): ?>
	<?php //p($v);p($v['child']); ?>
<div class="row-fluid">
    <div class="block span12">
        <div class="block-heading" data-toggle="collapse" data-target="#widget2container<?php echo $v['cat_id'] ?>">
	        <table class="table">
		      <tbody>
		         <tr>
					<th><?php echo $v['cat_name'] ;?></th>
					<th><?php echo $v['is_show'] ;?></th>
					<th><?php echo $v['sort_order'] ;?></th>
					<th><?php echo $v['opera'] ;?></th>
				</tr>
		      </tbody>
		    </table>
        </div>
        <?php if ($v['has_children']) {
        	echo '<div id="widget2container'.$v['cat_id'].'" class="block-body collapse in">';
        	echo '<table class="table"><table class="table"><tbody>';
        	foreach($child as $v1){
        		if ($v['cat_id'] == $v1['parent_id']) {
		             	echo '<span><tr><td>'.$v1['cat_name'].'</td><td>'.$v1['is_show'].'</td><td>'.$v1['sort_order'].'</td><td>'.$v1['opera'].'</td></tr></span>';
		        }
        	}
        	echo '</tbody></table></div>';
        } ?>
    </div>
   
</div>
<?php endforeach ?>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/room/classify.js" type="text/javascript"></script>
