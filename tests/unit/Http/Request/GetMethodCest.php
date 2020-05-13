<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Http\Request;

use Phalcon\Http\Request;
use UnitTester;

class GetMethodCest
{
    /**
     * Tests Phalcon\Http\Request :: getMethod()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-03-17
     */
    public function httpRequestGetMethod(UnitTester $I)
    {
        $I->wantToTest('Http\Request - getMethod()');

        // Default
        unset($_SERVER['REQUEST_METHOD']);
        $request = new Request();

        $I->assertEquals('GET', $request->getMethod());

        // Valid
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $request = new Request();

        $I->assertEquals('POST', $request->getMethod());

        // Valid POST Override
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['X_HTTP_METHOD_OVERRIDE'] = 'TRACE';
        $request = new Request();

        $I->assertEquals('TRACE', $request->getMethod());
        unset($_SERVER['X_HTTP_METHOD_OVERRIDE']);

        // Valid POST spoof
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_REQUEST['_method'] = 'CONNECT';
        $request = new Request();
        $request->setHttpMethodParameterOverride(true);

        $I->assertEquals('CONNECT', $request->getMethod());
        unset($_REQUEST['_method']);

        // Invalid
        $_SERVER['REQUEST_METHOD'] = 'UNKNOWN';
        $request = new Request();

        $I->assertEquals('GET', $request->getMethod());
    }
}
