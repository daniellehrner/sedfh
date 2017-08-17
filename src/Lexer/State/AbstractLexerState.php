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

namespace Dl\Sedfh\Lexer\State;

abstract class AbstractLexerState implements LexerState
{
    protected $stateName;

    private $exceptionMessage = 'State %s can\'t be reached from %s';

    /**
     * @throws IllegalStateTransitionException
     */
    public function start()
    {
        throw new IllegalStateTransitionException(sprintf($this->exceptionMessage, 'start', $this->stateName));
    }

    /**
     * @throws IllegalStateTransitionException
     */
    public function keyword()
    {
        throw new IllegalStateTransitionException(sprintf($this->exceptionMessage, 'keyword', $this->stateName));
    }

    /**
     * @throws IllegalStateTransitionException
     */
    public function string()
    {
        throw new IllegalStateTransitionException(sprintf($this->exceptionMessage, 'string', $this->stateName));
    }

    /**
     * @throws IllegalStateTransitionException
     */
    public function end()
    {
        throw new IllegalStateTransitionException(sprintf($this->exceptionMessage, 'end', $this->stateName));
    }
}
