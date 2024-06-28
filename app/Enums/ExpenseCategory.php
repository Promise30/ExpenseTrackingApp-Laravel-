<?php

namespace App\Enums;

enum ExpenseCategory: string
{
    //
    case FOOD = "Food";
    case UTILITIES = "Utilities";
    case TRANSPORTATION = "Transportation";
    case LEISURE = "Leisure";
    case CLOTHING = "Clothing";
    case MISCELLANEOUS = "Miscellaneous";
    case OTHERS = "Others";

}
