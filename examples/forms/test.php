<?php

$form = new Nette\Forms\Form;

$form->addText('text1', 'Text 1');
$form->addSubmit('submit', 'Submit');

$form->addGroup('group1');
$form->addText('text2', 'Text 2');
$form->addText('text3', 'Text 3');

