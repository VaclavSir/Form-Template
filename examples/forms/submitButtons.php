<?php


use Nette\Forms\Form;

$form = new Form;
$form->addText('aaa', 'Aaa');
$form->addGroup('Some Group');
$form->addText('bbb', 'Bbb');
$form->addSubmit('submit', 'Submit');
$form->addSubmit('another', 'Another Submit');
$form->addText('ccc', 'Ccc');
$form->addSubmit('onemore', 'One More Submit');
