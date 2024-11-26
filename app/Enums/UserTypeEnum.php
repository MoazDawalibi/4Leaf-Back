<?php
namespace App\Enums;

enum UserTypeEnum : string {
    case User = 'user';
    case Viewer = 'viewer';
    case Admin = 'admin';
}