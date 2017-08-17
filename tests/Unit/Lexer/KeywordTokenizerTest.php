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
use Dl\Sedfh\Token\TokenStatement;
use PHPUnit\Framework\TestCase;

class KeywordTokenizerTest extends TestCase
{
    /**
     * @var KeywordTokenizer
     */
    private $keywordTokenizer;

    public function setUp()
    {
        $this->keywordTokenizer = new KeywordTokenizer();
    }

    /**
     * @dataProvider tokenizeProvider
     */
    public function testReturnReplaceToken($lexeme)
    {
        $token = $this->keywordTokenizer->tokenize($lexeme);

        $this->assertInstanceOf(
            TokenStatement::class,
            $token,
            'KeywordTokenizer::tokenize should return a token with the class Token\TokenStatement if the lexeme '.$lexeme.' is used'
        );

        $this->assertEquals(
            'replace',
            $token->getValue(),
            'KeywordTokenizer::tokenize  should return a token with the value replace if the keyword '.$lexeme.' is used'
        );
    }

    public function testReturnNullIfUnknown()
    {
        $this->assertNull(
            $this->keywordTokenizer->tokenize('unknown'),
            'KeywordTokenizer::tokenize should return null for an unknown keyword'
        );
    }

    public function tokenizeProvider()
    {
        return array(
            array('replace'),
            array('Replace'),
        );
    }
}
