<?php

declare(strict_types=1);

namespace App\Form;

enum FieldType
{
    case Email;
    case PhoneNumber;
    case Text;
}
