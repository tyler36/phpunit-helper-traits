<?php


/**
 * Class DisableExceptionHandlerTraitTest
 *
 * @test
 * @group trait
 * @group disableExceptionHandlerTrait
 */
class DisableExceptionHandlerTraitTest extends TestCase
{
    use tyler36\phpunitTraits\DisableExceptionHandlerTrait;


    /**
     * SETUP
     */
    public function setUp()
    {
        // INCLUDE:     parent setup
        parent::setUp();

        // DEFINE:      test route
        Route::get('user/{ $user }', ['as' => 'test', function () {
            return 'nice';
        }]);
    }


    /**
     * TEST:        Route is not valid
     */
    public function testRouteThrowsException()
    {
        // VISIT:       Site
        $this->call('get', 'test');

        // ASSERT:      Response Error
        $this->assertResponseStatus(404);
    }


    /**
     * TEST:        Use trait to capture error
     */
    public function testUsingTraitThrowsError()
    {
        $this->disableExceptionHandling();

        try {
            // VISIT:       Site
            $this->call('get', 'test');

            // ASSERT:      Response Error
            $this->assertResponseStatus(404);
        } catch (Exception $err) {
            // ASSERT:      Exception thrown by 'RouteCollection.php'
            $this->assertContains('RouteCollection.php', $err->getFile());
        }
    }
}
