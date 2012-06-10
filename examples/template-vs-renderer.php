<?php

require_once __DIR__ . '/nette.min.php';

Nette\Diagnostics\Debugger::enable();


$sourceSelectForm = new Nette\Forms\Form;
$sourceSelectForm->addSelect('source', 'Formulář: ', array(
			'Forms.example.001.phpt' => 'Nette Test Suite #001',
			'Forms.example.002.phpt' => 'Nette Test Suite #002 (CSRF)',
			'Forms.example.005.phpt' => 'Nette Test Suite #005 (Custom validator)',
			'Forms.example.006.phpt' => 'Nette Test Suite #006 (Naming containers)',
			'Forms.example.007.phpt' => 'Nette Test Suite #007 (No labels)',
			'Forms.example.008.phpt' => 'Nette Test Suite #008 (HTML5)',
			'submitButtons.php' => 'Submit buttons',
			'test.php' => 'Test'
		))
		->setDefaultValue('Forms.example.001.phpt');
$sourceSelectForm->addSelect('template', 'Šablona: ', array(
			'basic.latte' => 'Základní @form.latte',
			'list.latte' => 'Seznam místo tabulky',
			'ascii-art.latte' => 'Ascii-Art Controls'
		))
		->setDefaultValue('basic.latte');
$sourceSelectForm->addSubmit('show', 'Zobrazit');


$sourceSelectForm->fireEvents();
$formFileName = __DIR__ . '/forms/' . $sourceSelectForm->values['source'];
$formTemplate = $sourceSelectForm->values['template'];

require $formFileName;
$form->action = 'http://www.nasa.gov/';


$template = new Nette\Templating\FileTemplate(__DIR__ . '/templates/template-vs-renderer.latte');
$template->registerHelperLoader('Nette\Templating\Helpers::loader');
$template->registerFilter(new Nette\Latte\Engine);
$template->definition = file_get_contents($formFileName);
$template->form = $form;
$template->sourceSelectForm = $sourceSelectForm;
$template->formTemplate = $formTemplate;

$template->render();
