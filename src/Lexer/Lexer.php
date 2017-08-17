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

namespace Dl\Sedfh\Lexer;

use Dl\Sedfh\Lexer\State\IllegalStateTransitionException;
use Dl\Sedfh\Lexer\State\KeywordState;
use Dl\Sedfh\Lexer\State\LexerState;
use Dl\Sedfh\Lexer\State\StartState;
use Dl\Sedfh\Lexer\State\StringState;
use Dl\Sedfh\Token\TokenString;

class Lexer
{
    /**
     * @var KeywordTokenizer
     */
    private $evaluator;

    /**
     * @var LexerState
     */
    private $state;

    private $tokens = array();

    public function __construct(KeywordTokenizer $evaluator)
    {
        $this->evaluator = $evaluator;
        $this->state = new StartState();
    }

    public function tokenize(array $lexemes)
    {
        try {
            foreach ($lexemes as $lexeme) {
                if ($this->isStartState()) {
                    $this->setState($this->state->keyword());
                } elseif ($this->isKeywordState()) {
                    $this->setState($this->state->string());
                } elseif ($this->isStringState()) {
                    $this->setState($this->state->keyword());
                }

                if ($this->isKeywordState()) {
                    $this->addKeywordToken($lexeme);
                }

                if ($this->isStringState()) {
                    $this->addStringToken($lexeme);
                }
            }

            $this->setState($this->state->end());
        } catch (IllegalStateTransitionException $exception) {
            throw new LexerException('Invalid input string: '.$exception->getMessage());
        }

        return $this->tokens;
    }

    private function addKeywordToken($lexeme)
    {
        $token = $this->evaluator->tokenize($lexeme);

        if (is_null($token)) {
            throw new LexerException('Keyword expected, but '.$lexeme.' isn\'t one');
        }

        $this->tokens[] = $token;
    }

    private function addStringToken($lexeme)
    {
        $this->tokens[] = new TokenString($lexeme);
    }

    private function isState($state)
    {
        return $state === get_class($this->state);
    }

    private function isStartState()
    {
        return $this->isState(StartState::class);
    }

    private function isKeywordState()
    {
        return $this->isState(KeywordState::class);
    }

    private function isStringState()
    {
        return $this->isState(StringState::class);
    }

    private function setState(LexerState $state)
    {
        $this->state = $state;
    }
}
