<?php declare(strict_types = 1);

namespace App\Presenters;

use Contributte\Forms\IApplicationFormFactory;
use Contributte\Forms\Rendering\Bootstrap4VerticalRenderer;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
{

	/** @var IApplicationFormFactory */
	private $formFactory;

	public function __construct(IApplicationFormFactory $formFactory)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
	}

	protected function createComponentTestForm(): Form
	{
		$form = $this->formFactory->create();
		$form->setRenderer(new Bootstrap4VerticalRenderer());

		$form->addText('name', 'Name:')
			->setRequired();

		$form->addPassword('password', 'Password:')
			->setRequired()
			->addRule(Form::MIN_LENGTH, 'Password must bea at least %d characters long', 6);

		$form->addPassword('passwordVerify', 'Password again:')
			->setRequired('Please set the password again for check')
			->addRule(Form::EQUAL, 'Passwords are not equal', $form['password']);

		$roles = [
			'admin' => 'admin',
			'moderator' => 'moderator',
			'user' => 'user',
			'guest' => 'guest',
		];
		$form->addSelect('role', 'Role', $roles)
			->setHtmlAttribute('class', 'select2-example')
			->setPrompt('-- Select role --')
			->setRequired(true);

		$form->addMultiSelect('roles', 'Roles', $roles)
			->setHtmlAttribute('class', 'select2-example')
			->setRequired(true);

		$form->addSelect('another_role', 'Role', $roles)
			->setPrompt('-- Select role --')
			->setRequired(true);

		$form->addMultiSelect('another_roles', 'Roles', $roles)
			->setRequired(true);

		$form->addSubmit('signup', 'Sign up');

		$form->onSuccess[] = function (Form $form) {
			dump($form->getValues());
			bdump($form->getValues());
		};

		return $form;
	}

}
