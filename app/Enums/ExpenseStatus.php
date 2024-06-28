<?php

namespace App\Enums;

enum ExpenseStatus: string
{
    //
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';

}

