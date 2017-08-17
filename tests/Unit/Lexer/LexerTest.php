<?php
/*
 * Copyright (C) 2017 Daniel Lehrner
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Dl\SedfhTest\Unit\Lexer;

use Dl\Sedfh\Lexer\KeywordTokenizer;
use Dl\Sedfh\Lexer\Lexer;
use Dl\Sedfh\Lexer\LexerException;
use Dl\Sedfh\Token\TokenStatement;
use Dl\Sedfh\Token\TokenString;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{
    /**
     * @var Lexer
     */
    private $lexer;

    public function setUp()
    {
        $this->lexer = new Lexer(new KeywordTokenizer());
    }

    /**
     * @dataProvider tokenizeValidProvider
     */
    public function testTokenizeValid($lexemes, $tokens)
    {
        $this->assertEquals(
            $tokens,
            $this->lexer->tokenize($lexemes),
            'With the input ['.implode(', ', $lexemes).'] Lexer::tokenize should output ['.implode(', ', $tokens).']'
        );
    }

    /**
     * @dataProvider tokenizeInValidProvider
     */
    public function testTokenizeInvalid($lexemes)
    {
        $this->expectException(LexerException::class);

        $this->lexer->tokenize($lexemes);
    }

    public function tokenizeValidProvider()
    {
        return array(
            array(
                array('replace', 'test'),
                array(
                    new TokenStatement('replace'),
                    new TokenString('test')
                )
            ),
            array(
                array('replace', 'test', 'with', 'two words'),
                array(
                    new TokenStatement('replace'),
                    new TokenString('test'),
                    new TokenStatement('with'),
                    new TokenString('two words'),
                )
            ),
        );
    }

    public function tokenizeInValidProvider()
    {
        return array(
            array(array('replace')),
            array(array('replace', 'test', 'with')),
        );
    }
}