<?php


class FormTestCest
{
    public function _before(AcceptanceTester $I)
    {

    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests

    /**
     * @param \AcceptanceTester $I
     * @throws \Exception
     * @env local
     */
    public function tryToTest(AcceptanceTester $I)
    {

        $I->deleteAllEmails();
        $I->amGoingTo('test the main contact form');
        $I->amOnPage('/');
//        $I->amOnPage('/form/');
         $I->click('Form');
        $I->waitForText('Contact Form');


        $name = 'Max Mustermann';
        $subject = 'Betreff der Mail';
        $sender = 'foo-bar@camp.test';
        $message = 'Lorem ipsum dolor sit';

        $I->fillField('#demo-name', $name);
        $I->fillField('#demo-subject', $subject);
        $I->fillField('#demo-email', $sender);
        $I->fillField('#demo-message', $message);
        $I->click('Next step');

        $I->waitForText('Summary page');

        $I->amGoingTo('Submit the form');
        $I->click('Submit');
        // firefox does not wait for the reload to check
        $I->waitForText('Thank you for contacting us');
        // this would work in chrome, but not in firefox
        // $I->see('Thank you for contacting us');

        $I->amGoingTo('Check the mail-inbox for the user');
        $I->fetchEmails();
        $I->haveNumberOfEmails(2);

        // with rewriting
        $I->accessInboxFor('mailtester+foo-bar-camp-test@example.org');
        // without rewriting
        // $I->accessInboxFor('foo-bar@camp.test');
        $I->openNextUnreadEmail();

        $I->canSeeInOpenedEmailToField($name);
        $I->seeInOpenedEmailBody($name);
        $I->canSeeInOpenedEmailBody($sender);
        $I->seeInOpenedEmailBody($message);
        $I->canSeeNoRelevantSpamScore();

        $I->amGoingTo('Check the mail-inbox for the admin mail');
        $I->accessInboxFor('mailtester+bar-camp-test@example.org');
        $I->openNextUnreadEmail();

        $I->seeInOpenedEmailSubject($subject);
        $I->canSeeInOpenedEmailBody($name);
        $I->canSeeInOpenedEmailSender($sender);
        $I->canSeeNoRelevantSpamScore();
    }
}
