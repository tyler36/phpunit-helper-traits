<?php

namespace tyler36\phpunitTraits;

use App\Guest;
use App\User;

/**
 * Class ImpersonateTrait
 *
 * @package phpunit
 */
trait ImpersonateTrait
{
    /**
     * Ensure authenticated or create User
     *
     * @param $user
     * @return $this
     */
    public function asMember($user = null)
    {
        // CHECK:       Status
        if (auth()->guest()) {
            // SETUP:       Member
            $user = $user ?: factory(User::class)->create();
            $this->be($user);
        }

        // ASSERT:      Member
        $this->assertTrue(auth()->check());

        return $this;
    }


    /**
     * Ensure Guest status
     *
     * @return $this
     */
    public function asGuest()
    {
        // CHECK:       Status
        if (auth()->check()) {
            // Logout User
            auth()->logout();
        }

        // ASSERT:      Guest
        $this->assertTrue(auth()->guest());

        return $this;
    }
}
