<?php

namespace tyler36\phpunitTraits;

use Mail;
use Swift_Message;

/**
 * Class MailTrackerTrait
 * Based on Laracast lesson: https://laracasts.com/series/phpunit-testing-in-laravel/episodes/12
 *
 * @package phpunit
 */
trait MailTrackerTrait
{
    /**
     * Store sent emails
     *
     * @var array
     */
    protected $emails = [];


    /** @before */
    public function setUpMailTracking()
    {
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));
    }


    /**
     * Append email to array
     *
     * @param Swift_Message $email
     */
    public function addEmail(Swift_Message $email)
    {
        $this->emails[] = $email;
    }


    /**
     * Assert email was NOT sent
     */
    protected function seeEmailWasNotSent()
    {
        $count = count($this->emails);

        $this->assertEmpty(
            $this->emails,
            "Did not expect any emails sent, but sent count was $count."
        );

        return $this;
    }


    /**
     * Assert email was sent
     */
    protected function seeEmailWasSent()
    {
        $this->assertNotEmpty(
            $this->emails,
            'No emails have been sent.'
        );

        return $this;
    }


    /**
     * Assert number of sent emails
     *
     * @param $count
     * @return $this
     */
    protected function seeEmailsSent($count)
    {
        $emailsSent = count($this->emails);

        $this->assertCount(
            $count,
            $this->emails,
            "Expected $count emails but sent count was $emailsSent."
        );

        return $this;
    }


    /**
     * Assert email was sent to $recipient
     *
     * @param               $recipient
     * @param Swift_Message $message
     * @return $this
     */
    protected function seeEmailTo($recipient, Swift_Message $message = null)
    {
        $this->assertArrayHasKey(
            $recipient,
            $this->getEmail($message)->getTo(),
            "No email was sent to $recipient."
        );

        return $this;
    }


    /**
     * Assert email was NOT sent to $recipient
     *
     * @param               $recipient
     * @param Swift_Message $message
     * @return $this
     */
    protected function seeEmailNotTo($recipient, Swift_Message $message = null)
    {
        $this->assertArrayNotHasKey(
            $recipient,
            $this->getEmail($message)->getTo(),
            "Did not expect email to be sent to $recipient, but it was."
        );

        return $this;
    }


    /**
     * Assert email was sent from $sender
     *
     * @param                    $sender
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailFrom($sender, Swift_Message $message = null)
    {
        $this->assertArrayHasKey(
            $sender,
            $this->getEmail($message)->getFrom(),
            "No email was sent from $sender."
        );

        return $this;
    }


    /**
     * Assert email was NOT sent from $sender
     *
     * @param                    $sender
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailNotFrom($sender, Swift_Message $message = null)
    {
        $this->assertArrayNotHasKey(
            $sender,
            $this->getEmail($message)->getFrom(),
            "Did not expect email to be sent from $sender, but it was."
        );

        return $this;
    }


    /**
     * Assert email body matches expected result
     *
     * @param                    $body
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailEquals($body, Swift_Message $message = null)
    {
        $this->assertEquals(
            $body,
            $this->getEmail($message)->getBody(),
            'No email with the provided body was sent.'
        );

        return $this;
    }


    /**
     * Assert email body NOT matches expected result
     *
     * @param                    $body
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailNotEquals($body, Swift_Message $message = null)
    {
        $this->assertNotEquals(
            $body,
            $this->getEmail($message)->getBody(),
            'Expected email body to be different but it was the same.'
        );

        return $this;
    }


    /**
     * Assert Email body contains some text
     *
     * @param                    $excerpt
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailContains($excerpt, Swift_Message $message = null)
    {
        $this->assertContains(
            $excerpt,
            $this->getEmail($message)->getBody(),
            'Expected text was not found in the body.'
        );

        return $this;
    }


    /**
     * Assert Email body DOES NOT contains some text
     *
     * @param                    $excerpt
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailNotContains($excerpt, Swift_Message $message = null)
    {
        $this->assertNotContains(
            $excerpt,
            $this->getEmail($message)->getBody(),
            'Did not expect to see text but it was found.'
        );

        return $this;
    }


    /**
     * Assert Email subject matches
     *
     * @param                    $subject
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailSubjectEquals($subject, Swift_Message $message = null)
    {
        $this->assertEquals(
            $subject,
            $this->getEmail($message)->getSubject(),
            'Email subject was different.'
        );

        return $this;
    }


    /**
     * Assert Email subject matches
     *
     * @param                    $subject
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailSubjectNotEquals($subject, Swift_Message $message = null)
    {
        $this->assertNotEquals(
            $subject,
            $this->getEmail($message)->getSubject(),
            'Expected a different subject line.'
        );

        return $this;
    }


    /**
     * Assert Email body contains some text
     *
     * @param                    $excerpt
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailSubjectContains($excerpt, Swift_Message $message = null)
    {
        $this->assertContains(
            $excerpt,
            $this->getEmail($message)->getSubject(),
            'Expected text was not found in the subject.'
        );

        return $this;
    }


    /**
     * Assert Email body DOES NOT contains some text
     *
     * @param                    $excerpt
     * @param Swift_Message|null $message
     * @return $this
     */
    protected function seeEmailSubjectNotContains($excerpt, Swift_Message $message = null)
    {
        $this->assertNotContains(
            $excerpt,
            $this->getEmail($message)->getSubject(),
            'Did not expect to see text in subject but it was found.'
        );

        return $this;
    }


    /**
     * Get email message or most recent sent
     *
     * @param Swift_Message|null $message
     * @return mixed
     */
    protected function getEmail(Swift_Message $message = null)
    {
        $this->seeEmailWasSent();

        return $message ?: $this->lastEmailSent();
    }


    /**
     * Get last email sent
     *
     * @return mixed
     */
    protected function lastEmailSent()
    {
        return end($this->emails);
    }
}
