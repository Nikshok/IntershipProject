<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;

class MessageParser
{
    const PATTERNS = [
        'search_start' => '',
        'search_cancel' => '',
        'answer' => '',
        'surrender' => '',
    ];

    public function parseMessage($message)
    {
        foreach (self::PATTERNS as $patter) {
            if (preg_match($patter, $message)) {

            }
        }
    }
}