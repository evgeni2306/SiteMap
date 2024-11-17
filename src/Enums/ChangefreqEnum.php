<?php

declare(strict_types=1);

namespace Sitemap\Enums;
enum ChangefreqEnum: string
{
    case ALWAYS = 'always';
    case HOURLY = 'hourly';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case NEVER = 'never';
}
