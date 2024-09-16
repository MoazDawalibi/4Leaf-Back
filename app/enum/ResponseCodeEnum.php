<?php
namespace App\enum;

enum ResponseCodeEnum : int {
    case RESOURCE_NOT_FOUND = 404;
    case ACCESS_DENIED = 403;
    case INTERNAL_SERVER_ERROR = 500;
    case BAD_REQUEST = 400;
}