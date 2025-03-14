<?php

namespace App\Enums;

enum PaymentType: int
{
    case PAYMENT = 0;
    case TRANFER = 1;
    case REFUND = 2;
    case ADJUSTMENT = 3;
    case SETTLEMENT = 3;
}
