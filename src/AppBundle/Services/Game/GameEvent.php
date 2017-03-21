<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;

class GameEvent
{
    const EVENTS = [
        'search_start' => 'SearchStartEvent',
        'search_cancel' => 'SearchCancelEvent',
        'answer' => 'AnswerEvent',
        'surrender' => 'SurrenderEvent',
    ];

    public function createEvent($inner_event)
    {
        foreach (self::EVENTS as $event) {
            if ($event == $inner_event) {
                return new $event();        //EventClass
            }
        }
    }
}