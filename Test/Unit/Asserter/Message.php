<?php

namespace Atoum\HttpExtension\Test\Unit\Asserter;

use atoum\test;
use mock\Psr\Http\Message\MessageInterface as FakeMessage;

class Message extends test {

    public function testClassical ( ) {

        $this
            ->given(
                $message = new FakeMessage(),
                $this->calling($message)->hasHeader = function ( ) {

                    return true;
                },
                $this->calling($message)->getHeader = function ( ) {

                    return 'foo';
                }
            )
            ->then
                ->httpRequest($message)
                    ->hasHeader('bar', 'foo')
                ->boolean(true)
                    ->isTrue();
    }
}
