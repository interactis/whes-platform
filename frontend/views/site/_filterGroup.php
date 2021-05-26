<?php
$groupId = 'filter-'. $model->id;
?>

<div class="collapse-item">
	<div class="collapse-title collapse-title-sm" data-toggle="collapse" data-target="#<?= $groupId ?>" aria-expanded="true" aria-controls="<?= $groupId ?>">
		<div class="row title-content">
			<div class="col-lg-12">
				<svg class="handle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.42 58.95"><g data-name="Layer 2"><path fill="none" stroke="#A60100" stroke-miterlimit="10" stroke-width="7" d="M2.48 2.48l27 27-27 27" /></g></svg>
				<div class="h4">
					<?= $model->title ?>
					<?php /*
					<small class="<?= $model->id ?>-filter-set-check text-primary <?= ($filtersSet ? "" : "hidden"); ?>"><i class="fa fa-check "></i></small>
					*/
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="collapse collapse-sm show" id="<?= $groupId ?>">
		<div class="collapse-wrapper">
				
			<?php foreach ($model->activeFlags as $flag):
				$filterId = 'detail-filter-'. $flag->id;
				?>
				<div class="custom-control custom-control-sm custom-checkbox">
					<input value="" class="custom-control-input" id="<?= $filterId ?>" name="<?= $filterId ?>" type="checkbox">
					<label class="custom-control-label" for="<?= $filterId ?>"><?= $flag->title ?></label>
				</div>
			<?php endforeach; ?>
			
			
			<?php
			/*
			foreach ($filterParams[$type .'s'] as $item): ?>
				<div class="custom-control <?= ($item['selected'] == 1 ? "active" : ""); ?> custom-control-sm custom-checkbox">
					<input value="<?= $item['slug'] ?>" class="custom-control-input <?= $type ?>-filter" id="<?= $type ?>-<?= $item['slug'] ?>" name="<?= $type ?>-<?= $item['slug'] ?>" type="checkbox" <?= ($item['selected'] == 1 ? "checked" : ""); ?>>
					<label class="custom-control-label" for="<?= $type ?>-<?= $item['slug'] ?>"><?= $item['title'] ?></label>
				</div>
			<?php endforeach; ?>
			*/
			?>
		
		</div>
	</div>
</div>
