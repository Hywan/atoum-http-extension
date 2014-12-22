<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2014, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Atoum\HttpExtension\Asserter;

use mageekguy\atoum\asserters;
use Psr;

/**
 * Class \Atoum\HttpExtension\Asserter\Message.
 *
 * 
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2014 Ivan Enderlin.
 * @license    New BSD License
 */

abstract class Message extends asserters\object {

    protected $_version = null;
    protected $_headers = null;

    public function setWith ( $value, $checkType = true ) {

        parent::setWith($value, $checkType);

        // + instanceof
        if(!($value instanceof Psr\Http\Message\MessageInterface))
            $this->fail(
                sprintf(
                    $this->getLocale()->_('%s is not a valid HTTP message.'),
                    $value
                )
            );

        return $this;
    }

    protected function valueIsSet ( $message = 'HTTP message is undefined' ) {

        return parent::valueIsSet($message);
    }

    protected function getInnerAsserter ( $name, $asserterClassName ) {

        if(null === $this->$name)
            $this->$name = new $asserterClassName($this->getGenerator());

        return $this->$name;
    }

    public function __get ( $name ) {

        $_value = $this->valueIsSet()->getValue();

        switch(strtolower($name)) {

            case 'version':
                $out   = $this->getInnerAsserter(
                    '_version',
                    asserters\string::class
                );
                $value = $_value->getProtocolVersion();
              break;

            case 'headers':
                $out   = $this->getInnerAsserter(
                    '_headers',
                    asserters\phpArray::class
                );
                $value = $_value->getHeaders();
              break;

            default:
                return parent::__get($name);
        }

        $out->setWith($value);

        return $out;
    }

    public function hasHeader ( $name ) {

        static $boolean = null;

        if(null === $boolean)
            $boolean = new asserters\boolean($this->getGenerator());

        $boolean->setWith($this->valueIsSet()->getValue()->hasHeader($name));

        return $boolean;
    }

    public function header ( $name ) {

        static $string = null;

        if(null === $string)
            $string = new asserters\string($this->getGenerator());

        $string->setWith($this->valueIsSet()->getValue()->getHeader($name));

        return $string;
    }

    public function headerAsArray ( $name ) {

        static $array = null;

        if(null === $array)
            $array = new asserters\phpArray($this->getGenerator());

        $array->setWith($this->valueIsSet()->getValue()->getHeaderAsArray($name));

        return $array;
    }
}
