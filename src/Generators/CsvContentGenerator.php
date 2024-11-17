<?php

declare(strict_types=1);

namespace Sitemap\Generators;


use Sitemap\Interfaces\ContentGeneratorInterface;

class CsvContentGenerator implements ContentGeneratorInterface
{
    /**
     * @param array $pagesArr
     * @return string
     */
    public function generate(array $pagesArr): string
    {
        $fileContent = '';
        $headerContent = 'loc;lastmod;priority;changefreq' . PHP_EOL;
        $fileContent = $fileContent . $headerContent;
        foreach ($pagesArr as $page) {
            $line = $page['loc'] . ';' . $page['lastmod'] . ';' . $page['priority'] . ';' . $page['changefreq'] . PHP_EOL;
            $fileContent = $fileContent . $line;
        }

        return $fileContent;
    }
}