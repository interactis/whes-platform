<?php
$groupId = 'filter-group-'. $model->id;
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
				$filterId = 'filter-'. $flag->id;
				$active = in_array($flag->id, $filters);
				?>
				<div class="custom-control custom-control-sm custom-checkbox <?= ($active ? "active" : ""); ?>">
					<input value="" class="custom-control-input filter-checkbox" id="<?= $filterId ?>" name="<?= $filterId ?>" type="checkbox" <?= ($active ? "checked" : ""); ?>>
					<label class="custom-control-label" for="<?= $filterId ?>"><?= $flag->title ?></label>
				</div>
			<?php endforeach; ?>
		
		</div>
	</div>
</div>
