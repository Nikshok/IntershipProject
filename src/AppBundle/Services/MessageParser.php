<?php

namespace AppBundle\Services;

class MessageParser
{
    const ACTIONS = [
        'GameSearchEvent' => 'поиск',
        'GameCancelEvent' => 'отмена',
        'GameStartEvent' => 'готов',
        'GameCapitulateEvent' => 'сдаться',
        'GameAnswerEvent' => 'ответ',
        'GameTopEvent' => 'топ'
    ];

    const ANSWERS = ['1', '2', '3', '4'];

    public function parseMessage($message)
    {
        $param = null;

        if (mb_strlen(trim($message)) == 1) {
            foreach (self::ANSWERS as $answer) {
                if (mb_stristr($message, $answer)){
                    $param = $answer;
                    return ['event_name' => 'GameAnswerEvent', 'param' =>  $param];
                }
            }
        }

        foreach (self::ACTIONS as $eventName => $action) {
            if (mb_stristr($message, $action)) {
                return ['event_name' => $eventName, 'param' => $param];
            }
        }

        return ['event_name' => 'GameErrorEvent', 'param' =>  $param];
    }
}