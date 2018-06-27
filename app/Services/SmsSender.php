<?php

namespace App\Services;

interface SmsSender
{
    public function send($number, $text): void;
}