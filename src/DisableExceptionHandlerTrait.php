<?php

namespace tyler36\phpunitTraits;

use App\Exceptions\Handler;
use Exception;

/**
 * Class DisableExceptionHandlerTrait
 *
 * @package tyler36\phpunitTraits
 */
trait DisableExceptionHandlerTrait
{
    /**
     * Turn off Laravel default Exception Handling to dump Exception to console
     */
    public function disableExceptionHandling()
    {
        app()->instance(Handler::class, new class extends Handler
        {
            /**
             * @name Constructor
             * @desc Override constructor because we don't need Logger dependency
             */
            public function __construct()
            {
                // Over-ride class with empty function
            }


            /**
             * @name             report
             * @desc Override report because we don't need Logger dependency
             * @param Exception $err
             */
            public function report(Exception $err)
            {
                // Over-ride class with empty function
            }


            /**
             * @name                           render
             * @desc    Override default to throw exception to console
             *
             * @param \Illuminate\Http\Request $request
             * @param Exception               $err
             * @return bool
             * @throws Exception
             */
            public function render($request, Exception $err)
            {
                if ($err) {
                    throw $err;
                }

                return false;
            }
        });
    }
}
