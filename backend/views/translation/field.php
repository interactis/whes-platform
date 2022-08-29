<?php
use yii\helpers\Html;
use common\models\Language;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;

$js = "
	$('.switch-tabs-en').click(function(e){
		e.preventDefault();
    	$('.en').tab('show');
    });
    
    $('.switch-tabs-fr').click(function(e){
		e.preventDefault();
    	$('.fr').tab('show');
    });
	
	$('.switch-tabs-de').click(function(e){
		e.preventDefault();
    	$('.de').tab('show');
    });
    
    $('.switch-tabs-it').click(function(e){
		e.preventDefault();
    	$('.it').tab('show');
    });
";

$this->registerJs($js, $this::POS_READY);

$tabs = "";
$tabContent = "";

if (!isset($isTextArea))
	$isTextArea = false;
	
if (!isset($isWysiwyg))
	$isWysiwyg = false;

if (!isset($height))
	$height = 180;

if (!isset($multiForm))
	$multiForm = false;
	
foreach (Language::getLanguages() as $langCode => $langId)
{
	$tabClass = "";
	$tabContentClass = "";
	$formField = null;
	$value = '';
	$fileHtml = "";
	
	// if de = default = first tab
	if ($langCode == 'de')
	{
		$tabClass = "active";
		$tabContentClass = "in active";
	}
	
	$tabContentId = $field .'-'. $langCode;
	if ($multiForm)
		$tabContentId = $field .'-'. $langCode .'-'. $multiFormId;
		
	$tabs .= '<li class="'. $tabClass .'"><a data-toggle="tab" href="#'. $tabContentId .'" class="'. $langCode .'">'. strtoupper($langCode) .'</a></li>';

	foreach ($translations as $translation)
	{
		// if ($translation->language_id == $langId && $translation->$field != '')
		if ($translation->language_id == $langId)
		{
			if (in_array($field, $model->hyphenFields))
			{
				$translation->$field = str_replace('&shy;', '|', $translation->$field);
			}
			
			$formField = $form->field($translation, "[{$translation->language_id}]{$field}");
			if ($multiForm)
				$formField = $form->field($translation, "[{$multiFormId}][{$translation->language_id}]{$field}");
			
			
			// add file html if file input
			if (isset($isFileInput) && $isFileInput === true)
			{
				if ($translation->filename != "")
				{
					$link = Yii::$app->params['frontendUrl'] .'file/'. strtolower($model->tableName()) .'/'. $langCode .'/'. $translation->filename;
					
					$icon = '<span class="glyphicon glyphicon-file" aria-hidden="true"></span>';
					if ($fileType == 'mp3')
						$icon = '<span class="glyphicon glyphicon-headphones" aria-hidden="true"></span>';
					
					$fileHtml = "<div>". Html::a($icon .' '. $translation->filename, $link, ['target' => '_blank']) ."</div>";
					$fileHtml .= '<div class="help-block"></div>';
				}
			}
			
			break;
		}
	}
	
	// load data from POST if available
	if (isset($_POST[$model->getTranslationTableNameOnly()][$langId][$field]))
	{
		$translationModel->language_id = $langId;
		$translationModel->$field = $_POST[$model->getTranslationTableNameOnly()][$langId][$field];
		$formField = $form->field($translationModel, "[{$langId}]{$field}");
	}
	
	// if no translated content was found
	if ($formField == null)
	{
		$formField = $form->field($translationModel, "[{$langId}]{$field}");
		if ($multiForm)
			$formField = $form->field($translationModel, "[{$multiFormId}][{$langId}]{$field}");
	}
    
    if ($isTextArea)
		$formField = $formField->textArea(['rows' => '6']);
	
	if ($isWysiwyg) {
		
		$clientOptions = [
			'height' => $height,
			'toolbarGroups' => [
				['name' => 'undo'],
				['name' => 'styles'],
				['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
				['name' => 'links', 'groups' => ['links']],
				['name' => 'paragraph', 'groups' => ['list']],
				['name' => 'format_tags', ],
				// ['name' => 'document', 'groups' => ['mode', 'document', 'doctools' ]],
			],
			'removeButtons' => 'Styles,Anchor,Subscript,Superscript,Underline,Strike',
			'format_tags' => 'p;h2;h3;pre'
		];

		$formField = $formField->widget(CKEditor::className(), [
            'preset' => 'custom',
            'clientOptions' => $clientOptions,
        ]);
	}
		
	if (isset($isFileInput) && $isFileInput === true)
	{
		$formField = $formField->widget(FileInput::classname(), [
			'options' => ['accept' => $fileType],
			'pluginOptions' => [
				'showPreview' => false,
				'showCaption' => true,
				'showRemove' => true,
				'showUpload' => false
			]
		]);
	}
    
    $formField->label(false);
    
    if (isset($hint))
    	$formField->hint($hint);
    	
    $tabContent .= '<div id="'. $tabContentId .'" class="tab-pane fade '. $tabContentClass .' '. $langCode .'">'. $formField . $fileHtml .'</div>';
}
?>

<?php
if (!isset($hideLabel))
	echo Html::label($translationModel->getAttributeLabel($field));
?>

<ul class="nav nav-tabs"><?= $tabs ?></ul>
<div class="help-block"></div>
<div class="tab-content"><?= $tabContent ?></div>
