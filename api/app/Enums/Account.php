<?php

namespace App\Enums;

final class Account extends Enum
{
    /**
     * Will indicate the account which caused the transaction.
     *
     * @var int
     */
    const FROM = 1;

    /**
     * Will indicate the account that received the transaction.
     *
     * @var int
     */
    const TO = 2;
}
