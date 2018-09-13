<?php

namespace Page\Acceptance;

class Form
{
    // include url of current page
    public static $URL = '';

    public static $subject = 'Hello Cluj!';
    public static $subjectField = '#demo-external-subject';

    public static $body = 'Testmessage';
    public static $bodyField = '#demo-external-message';

    public static $name = 'Form Tester';
    public static $nameField = '#demo-external-name';

    public static $emailField = '#demo-external-email';

    public static $submitButton = '#demo-external [type="submit"]';

    public static $summaryMessage = 'Summary page';
    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function goToFormPage()
    {
        $I = $this->acceptanceTester;
        $I->click('Form external');
        $I->seeElement('form');
    }

    public function fillFields()
    {
        $I = $this->acceptanceTester;
        $I->fillField(static::$nameField, static::$name);
        $I->fillField(static::$subjectField, static::$subject);
        $I->fillField(static::$bodyField, static::$body);
    }

    public function fillEmail($email)
    {
        $this->acceptanceTester->fillField(static::$emailField, $email);
    }

    public function submitForm()
    {
        $I = $this->acceptanceTester;
        $I->click(static::$submitButton);
        $I->see(static::$summaryMessage);
        $I->click(static::$submitButton);
    }
}
