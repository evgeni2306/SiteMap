<?php

declare(strict_types=1);

namespace Sitemap\Enums;
enum FileTypeEnum: string
{
    case CSV = 'CSV';
    case JSON = 'JSON';
    case XML = 'XML';
}