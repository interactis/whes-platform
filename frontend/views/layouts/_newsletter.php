<?php
$lang = Yii::$app->language;

$tagIds = [
	'bildung' => 7411240,
	'tourismus_de' => 7420520,
	'tourismus_en' => 7420524,
	'tourismus_fr' => 7420528,
	'tourismus_it' => 7420532
];

$tagId = $tagIds['bildung'];
if (Yii::$app->params['frontendType'] == 'visitor')
	$tagId = $tagIds['tourismus_'. $lang];
?>

<div id="mc_embed_shell" class="margin-bottom-lg">
	<div id="mc_embed_signup">
		<form action="https://unsererbe.us14.list-manage.com/subscribe/post?u=d86442a5f727b9b62adc3a322&amp;id=5b4dc62429&amp;f_id=00e789e0f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
			<div id="mc_embed_signup_scroll">
			
				<div class="h2 margin-bottom">Newsletter</div>
				
				<div class="margin-bottom">
					<div class="mc-field-group">
						<label class="control-label" for="mce-EMAIL"><?= Yii::t('app', 'Email') ?> <span class="asterisk">*</span></label>
						<input type="email" name="EMAIL" class="form-control required email" id="mce-EMAIL" required="" value="">
						<p class="help-block"></p>
					</div>
				
					<div class="mc-field-group">
						<label class="control-label" for="mce-FNAME"><?= Yii::t('app', 'First Name') ?></label>
						<input type="text" name="FNAME" class="form-control text" id="mce-FNAME" value="">
						<p class="help-block help-block-error"></p>
					</div>
				
					<div class="mc-field-group">
						<label class="control-label" for="mce-LNAME"><?= Yii::t('app', 'Last Name') ?></label>
						<input type="text" name="LNAME" class="form-control text" id="mce-LNAME" value="">
						<p class="help-block help-block-error"></p>
					</div>
				
					<div class="mc-field-group hidden">
						<select name="MMERGE3" class="required" id="mce-MMERGE3">
							<option value="DE" <?= ($lang == 'de' ? 'selected' : '')?>>DE</option>
							<option value="EN" <?= ($lang == 'en' ? 'selected' : '')?>>EN</option>
							<option value="FR" <?= ($lang == 'fr' ? 'selected' : '')?>>FR</option>
							<option value="IT" <?= ($lang == 'it' ? 'selected' : '')?>>IT</option>
						</select>
					</div>
					
					<div hidden="">
						<input type="hidden" name="tags" value="<?= $tagId ?>">
					</div>
				
					<div id="mce-responses" class="clear foot">
						<div class="response" id="mce-error-response" style="display: none;"></div>
						<div class="response" id="mce-success-response" style="display: none;"></div>
					</div>
				
					<div style="position: absolute; left: -5000px;" aria-hidden="true">
						/* real people should not fill this in and expect good things - do not remove this or risk form bot signups */
						<input type="text" name="b_d86442a5f727b9b62adc3a322_5b4dc62429" tabindex="-1" value="">
					</div>
					
				</div>
				
				<input type="submit" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary" value="<?= Yii::t('app', 'Subscribe') ?>">
				
			</div>
		</form>
	</div>
	<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script><script type="text/javascript">(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='BIRTHDAY';ftypes[5]='birthday';fnames[6]='MMERGE6';ftypes[6]='text';fnames[7]='MMERGE7';ftypes[7]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
</div>
