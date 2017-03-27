<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;

class MessageParser
{
    const ACTIONS = [
        'GameSearchEvent' => 'поиск',
        'GameCancelEvent' => 'отмена',
        'GameStartEvent' => 'готов',
        'GameCapitulateEvent' => 'сдаться',
        'GameAnswerEvent' => 'ответ',
    ];

    const ANSWERS = ['1', '2', '3', '4'];

    public function parseMessage($message)
    {
        $param = null;

        foreach (self::ACTIONS as $eventName => $action) {
            if (mb_stristr($message, $action)) {
                if ($action == self::ACTIONS['GameAnswerEvent']) {
                    foreach (self::ANSWERS as $answer) {
                        if (stristr($message, $answer)){
                            $param = $answer;
                        }
                    }
                }

                return ['event_name' => $eventName, 'param' => $param];
            }
        }

        return ['event_name' => 'GameErrorEvent', $param];
    }
}