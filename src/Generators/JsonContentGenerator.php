<?php

declare(strict_types=1);

namespace Sitemap\Generators;

use Sitemap\Interfaces\ContentGeneratorInterface;

class JsonContentGenerator implements ContentGeneratorInterface
{
    /**
     * @param array $pagesArr
     * @return string
     */
    public function generate(array $pagesArr): string
    {
        return json_encode($pagesArr);
    }
}