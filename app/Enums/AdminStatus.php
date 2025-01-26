<?php 
namespace App\Enums;

enum AdminStatus: string
{
    case Active = 'Active';
    case NotActive = 'Inactive';
}