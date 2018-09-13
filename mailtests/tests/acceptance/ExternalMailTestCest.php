<?php
class ExternalMailTestCest
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    /**
     * @param \AcceptanceTester $I
     * @env gmail
     */
    public function testGmail(AcceptanceTester $I)
    {
        // this mail is not on the whitelist and thus will be rewritten
        $mailAccount = getenv('GMAIL_USER');
        $I->amGoingTo('Test the form');

        $formPage = new \Page\Acceptance\Form($I);
        $formPage->goToFormPage();

        $formPage->fillFields();
        $formPage->fillEmail($mailAccount);

        $formPage->submitForm();

        $I->fetchEmails();

        // both emails will end up in the gmail inbox
        $I->haveNumberOfUnreadEmails(2);
    }


    /**
     * @param \AcceptanceTester $I
     * @env yandex
     */
    public function testYandex(AcceptanceTester $I)
    {
        // yandex screws up archiving, puts them under the inbox
        $I->deleteAllEmails();

        // this address will receive the mail, same as the one we fetch
        $mailAccount = getenv('YANDEX_USER');
        $I->amGoingTo('Test the form');

        $formPage = new \Page\Acceptance\Form($I);
        $formPage->goToFormPage();
        $formPage->fillFields();
        $formPage->fillEmail($mailAccount);
        $formPage->submitForm();

        $I->fetchEmails();

        // the mail to yandex will pass, thus we should have one in the inbox
        $I->haveNumberOfUnreadEmails(1);
        $I->accessInboxFor($mailAccount);
        $I->haveNumberOfUnreadEmails(1);
        $I->openNextUnreadEmail();
        $I->seeInOpenedEmailSubject('Thanks');
        $I->seeInOpenedEmailBody($formPage::$body);
    }
}