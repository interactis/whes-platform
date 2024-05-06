<?php if (isset($model->supplier)):
	$supplier = $model->supplier; ?>
	
	<?php if (!empty($supplier->name)): ?>
		<div class="margin-bottom-md">
			<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Provider') ?></div>
		
			<address class="margin-bottom-sm">
				<strong><?= $supplier->name ?></strong><br />
				<?= (!empty($supplier->name_affix) ? $supplier->name_affix .'<br />' : '') ?>
				<?= (!empty($supplier->street) ? $supplier->street .' '. $supplier->street_number .'<br />' : '') ?>
				<?= (!empty($supplier->address_addition) ? $supplier->address_addition .'<br />' : '') ?>
				<?= (!empty($supplier->zip) ? $supplier->zip .' ' : '') ?>
				<?= (!empty($supplier->city) ? $supplier->city .'<br />' : '') ?>
			</address>
		
			<div class="margin-bottom-sm">
				<?= (!empty($supplier->url) ? '<i class="fa fa-mouse-pointer"></i>&nbsp;&nbsp;<a href="'. $supplier->url .'">'. $supplier->url .'</a><br />' : '') ?>
				<?= (!empty($supplier->email) ? '<i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="mailto:'. $supplier->email .'">'. $supplier->email .'</a><br />' : '') ?>
				<?= (!empty($supplier->phone) ? '<i class="fa fa-phone"></i>&nbsp;&nbsp;'. $supplier->phone .'<br />' : '') ?>
			</div>
		
			<div class="small">
				<?= (!empty($supplier->remarks) ? $supplier->remarks : '') ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
