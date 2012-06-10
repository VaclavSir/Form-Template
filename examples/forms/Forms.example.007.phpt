<?php

/**
 * Test: Nette\Forms example.
 *
 * @author     David Grudl
 * @package    Nette\Forms
 * @subpackage UnitTests
 */

use Nette\Http,
	Nette\Forms\Form;



// require __DIR__ . '/../bootstrap.php';



$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array('name'=>'John Doe ','age'=>'  12 ','email'=>'@','street'=>'','city'=>'','country'=>'CZ','password'=>'xxx','password2'=>'xxx','note'=>'','userid'=>'231','submit1'=>'Send',);

$countries = array(
	'Europe' => array(
		'CZ' => 'Czech Republic',
		'SK' => 'Slovakia',
		'GB' => 'United Kingdom',
	),
	'CA' => 'Canada',
	'US' => 'United States',
	'?'  => 'other',
);

$sex = array(
	'm' => 'male',
	'f' => 'female',
);



// Step 1: Define form
$form = new Form;
$form->addText('name');
$form->addText('age');
$form->addRadioList('gender', NULL, $sex);
$form->addText('email')->setEmptyValue('@');

$form->addCheckbox('send');
$form->addText('street');
$form->addText('city');
$form->addSelect('country', NULL, $countries);

$form->addPassword('password');
$form->addPassword('password2');
$form->addUpload('avatar');
$form->addHidden('userid');
$form->addTextArea('note');

$form->addSubmit('submit');


// Step 1b: Define validation rules
$form['name']->addRule(Form::FILLED, 'Enter your name');

$form['age']->addRule(Form::FILLED, 'Enter your age');
$form['age']->addRule(Form::INTEGER, 'Age must be numeric value');
$form['age']->addRule(Form::RANGE, 'Age must be in range from %d to %d', array(10, 100));

// conditional rule: if is email filled, ...
$form['email']->addCondition(Form::FILLED)
	->addRule(Form::EMAIL, 'Incorrect email address'); // ... then check email

// another conditional rule: if is checkbox checked...
$form['send']->addCondition(Form::EQUAL, TRUE)
	// toggle div #sendBox
	->toggle('sendBox');

$form['city']->addConditionOn($form['send'], Form::EQUAL, TRUE)
	->addRule(Form::FILLED, 'Enter your shipping address');

$form['country']->addConditionOn($form['send'], Form::EQUAL, TRUE)
	->addRule(Form::FILLED, 'Select your country');

$form['password']->addRule(Form::FILLED, 'Choose your password');
$form['password']->addRule(Form::MIN_LENGTH, 'The password is too short: it must be at least %d characters', 3);

$form['password2']->addConditionOn($form['password'], Form::VALID)
	->addRule(Form::FILLED, 'Reenter your password')
	->addRule(Form::EQUAL, 'Passwords do not match', $form['password']);

$defaults = array(
	'name'    => 'John Doe',
	'userid'  => 231,
	'country' => 'CZ', // Czech Republic
);

$form->setDefaults($defaults);
$form->fireEvents();
