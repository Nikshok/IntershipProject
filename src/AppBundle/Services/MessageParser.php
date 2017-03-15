<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;

class MessageParser
{
    const ACTIONS = [
        'GameSearchEvent' => 'поиск',
        'GameCancelEvent' => 'отмена',
        'GameReadyEvent' => 'готов',
        'GameSurrenderEvent' => 'сдаться',
        'GameAnswerEvent' => 'ответ',
    ];

    const ANSWERS = ['1', '2', '3', '4'];

    public function parseMessage($message)
    {
        $param = null;

        foreach (self::ACTIONS as $eventName => $action) {
            if (stristr($message, $action)) {
                if ($action == self::ACTIONS['GameAnswerEvent']) {
                    foreach (self::ANSWERS as $answer) {
                        if (stristr($message, $answer)){
                            $param = $answer;
                        }
                    }
                }

                return ['EventName' => $eventName, 'parameters' => $param];
            }
        }

        return ['GameErrorEvent', $param];
    }
}