<?php


/**
 * Class MailTrackerTraitTest
 *
 * @test
 * @group trait
 * @group mail
 */
class MailTrackerTraitTest extends TestCase
{
    use tyler36\phpunitTraits\MailTrackerTrait;

    /**
     * @var string
     */
    protected $sender;
    protected $recipient;
    protected $body;
    protected $subject;


    /**
     * SETUP
     */
    public function setUp()
    {
        parent::setUp();

        // SETUP:   Mail configuration is LOG
        config()->set('mail.driver', 'log');

        $this->recipient = 'recipient@foo.com';
        $this->sender    = 'sender@foo.com';
        $this->body      = 'Hello World';
        $this->subject   = 'Email Subject';
    }


    /**
     * TEST:        Check no emails were sent
     *
     * @group seeEmailWasNotSent
     */
    public function testSeeEmailWasNotSent()
    {
        // ASSERT:      No mail was sent
        $this->seeEmailWasNotSent();
    }


    /**
     * TEST:        Check email was sent
     *
     * @group seeEmailWasSent
     */
    public function testsSeeEmailWasSent()
    {
        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Mail was sent
        $this->seeEmailWasSent();
    }


    /**
     * TEST:        Check email sent count
     *
     * @group seeEmailsSent
     */
    public function testSeeEmailsSent()
    {
        $count = 3;

        // LOOP:    Mail Count
        for ($i = 1; $i <= $count; $i++) {
            // MAIL:        Basic
            $this->sendTestMail();
        }

        // ASSERT:      Email counts
        $this->seeEmailsSent($count);
    }


    /**
     * TEST:        Check email recipient (TO)
     *
     * @group seeEmailTo
     * @group sender
     */
    public function testSeeEmailTo()
    {
        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Recipient
        $this->seeEmailTo($this->recipient);
    }


    /**
     * TEST:        Check not sent to email recipient (TO)
     *
     * @group seeEmailTo
     * @group sender
     */
    public function testSeeEmailNotTo()
    {
        // MAIL:        Basic
        $different = 'bar@bar.com';
        $this->assertNotEquals($different, $this->recipient);
        $this->sendTestMail();

        // ASSERT:      NOT Recipient
        $this->seeEmailNotTo($different);
    }


    /**
     * TEST:        Check email sender (FROM)
     *
     * @group seeEmailFrom
     * @group recipient
     */
    public function testSeeEmailFrom()
    {
        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Sender
        $this->seeEmailFrom($this->sender);
    }


    /**
     * TEST:        Check email not sender (FROM)
     *
     * @group seeEmailNotFrom
     * @group recipient
     */
    public function testSeeEmailNotFrom()
    {
        // MAIL:        Basic
        $different = 'bar@bar.com';
        $this->assertNotEquals($different, $this->sender);
        $this->sendTestMail();

        // ASSERT:      NOT Sender
        $this->seeEmailNotFrom($different);
    }


    /**
     * TEST:        Check email equals (BODY)
     *
     * @group seeEmailEquals
     * @group body
     */
    public function testSeeEmailEquals()
    {
        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Body Matches
        $this->seeEmailEquals($this->body);
    }


    /**
     * TEST:        Check email message not equals (BODY)
     *
     * @group seeEmailNotEquals
     * @group body
     */
    public function testSeeEmailNotEquals()
    {
        // MAIL:        Basic
        $different = 'New Message';
        $this->assertNotEquals($different, $this->body);
        $this->sendTestMail();

        // ASSERT:      Body NOT matches
        $this->seeEmailNotEquals($different);
    }


    /**
     * TEST:        Check email message contains (BODY)
     *
     * @group seeEmailContains
     * @group body
     */
    public function testSeeEmailContains()
    {
        //SETUP:    Get fragment
        $fragment = explode(' ', $this->body)[0];
        $this->assertContains($fragment, $this->body);

        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Body contains fragment
        $this->seeEmailContains($fragment);
    }


    /**
     * TEST:        Check email message NOT contains (BODY)
     *
     * @group seeEmailNotContains
     * @group body
     */
    public function testSeeEmailNotContains()
    {
        //SETUP:    Get fragment
        $fragment = 'Goodbye';
        $this->assertNotContains($fragment, $this->body);

        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Body NOT contains fragment
        $this->seeEmailNotContains($fragment);
    }


    /**
     * TEST:        Check email subject equals (SUBJECT)
     *
     * @group seeEmailSubjectEquals
     * @group subject
     */
    public function testSeeEmailSubjectEquals()
    {
        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Subject Matches
        $this->seeEmailSubjectEquals($this->subject);
    }


    /**
     * TEST:        Check email NOT subject (SUBJECT)
     *
     * @group seeEmailSubjectNotEquals
     * @group subject
     */
    public function testSeeEmailSubjectNotEquals()
    {
        // MAIL:        Basic
        $different = 'Another Subject';
        $this->assertNotEquals($different, $this->subject);
        $this->sendTestMail();

        // ASSERT:      Subject Matches
        $this->seeEmailSubjectNotEquals($different);
    }


    /**
     * TEST:        Check email subject contains (SUBJECT)
     *
     * @group seeEmailSubjectContains
     * @group subject
     */
    public function testSeeEmailSubjectContains()
    {
        //SETUP:    Get fragment
        $fragment = explode(' ', $this->subject)[0];
        $this->assertContains($fragment, $this->subject);

        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Subject contains
        $this->seeEmailSubjectContains($fragment);
    }


    /**
     * TEST:        Check email subject NOT contains (SUBJECT)
     *
     * @group seeEmailSubjectNotContains
     * @group subject
     */
    public function testSeeEmailSubjectNotContains()
    {
        //SETUP:    Get fragment
        $fragment = 'Goodbye';
        $this->assertNotContains($fragment, $this->subject);

        // MAIL:        Basic
        $this->sendTestMail();

        // ASSERT:      Subject NOT contains
        $this->seeEmailSubjectNotContains($fragment);
    }


    /**
     * Generic Mail send function
     */
    protected function sendTestMail()
    {
        // MAIL:        Basic
        Mail::raw($this->body, function ($message) {
            $message->to($this->recipient);
            $message->from($this->sender);
            $message->subject($this->subject);
        });
    }
}
