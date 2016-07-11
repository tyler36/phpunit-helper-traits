<?php

/**
 * Class ImpersonateTraitTest
 *
 * @test
 * @group trait
 * @group Impersonate
 */
class ImpersonateTraitTest extends TestCase
{
    use tyler36\phpunitTraits\ImpersonateTrait;


    /**
     * TEST:        'AsGuest' as Guest
     *
     * @group visitAsGuest
     * @group guest
     */
    public function testAsGuestBeingGuest()
    {
        // ASSERT:      Is Guest
        $this->assertTrue(auth()->guest());

        // CALL:        Trait
        $this->asGuest();

        // ASSERT:      Is Guest
        $this->assertTrue(auth()->guest());
    }


    /**
     * TEST:        'AsGuest' as Member
     *
     * @group visitAsGuest
     * @group member
     */
    public function testAsGuestBeingMember()
    {
        // SETUP:       Create User and login
        $user = factory(App\User::class)->create();
        $this->be($user);

        // ASSERT:      Is Member
        $this->assertTrue(auth()->check());

        // CALL:        Trait
        $this->asGuest();

        // ASSERT:      Is Guest
        $this->assertTrue(auth()->guest());
    }


    /**
     * TEST:        'AsMember' as Guest
     *
     * @group visitAsMember
     */
    public function testAsMemberBeingGuest()
    {
        // SETUP:       Ensure Guest
        auth()->logout();

        // ASSERT:      Is Guest
        $this->assertTrue(auth()->guest());

        // CALL:        Trait
        $this->asMember();

        // ASSERT:      Is Member
        $this->assertTrue(auth()->check());
    }


    /**
     * TEST:        'AsMember' as Member
     */
    public function testAsMemberBeingMember()
    {
        // SETUP:       Create User
        $user = factory(App\User::class)->create();

        // ASSERT:      Is Guest
        $this->assertTrue(auth()->guest());

        // CALL:        Trait
        $this->asMember();

        // ASSERT:      Is Member
        $this->assertTrue(auth()->check());
    }

    /**
     * TEST:        'AsMember' with User
     */
    public function testAsMemberWithUser()
    {
        // SETUP:       Create User
        $user = factory(App\User::class)->create();

        // CALL:        Trait
        $this->asMember($user);

        // ASSERT:      Is Member
        $this->assertTrue(auth()->check());

        // ASSERT:      Authenticated User
        $this->assertEquals($user->email, auth()->user()->email);
    }
}
