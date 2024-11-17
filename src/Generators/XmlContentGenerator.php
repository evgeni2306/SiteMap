<?php

declare(strict_types=1);

namespace Sitemap\Generators;

use DOMDocument;
use DOMException;
use Sitemap\Exceptions\FailToGenerateCsvException;
use Sitemap\Interfaces\ContentGeneratorInterface;

class XmlContentGenerator implements ContentGeneratorInterface
{
    /**
     * @param array $pagesArr
     * @return string
     * @throws FailToGenerateCsvException
     */
    public function generate(array $pagesArr): string
    {
        try {
            $dom = new DOMDocument('1.0', 'utf-8');
            $urlset = $dom->createElement('urlset');
            $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
            $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            $urlset->setAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
            foreach ($pagesArr as $page) {
                $url = $dom->createElement('url');
                $loc = $dom->createElement('loc', $page['loc']);
                $lastmod = $dom->createElement('lastmod', $page['lastmod']);
                $priority = $dom->createElement('priority', (string)$page['priority']);
                $changefreq = $dom->createElement('changefreq', $page['changefreq']);

                $url->appendChild($loc);
                $url->appendChild($lastmod);
                $url->appendChild($priority);
                $url->appendChild($changefreq);

                $urlset->appendChild($url);
            }
            $dom->appendChild($urlset);

            return $dom->saveXML();
        } catch (DOMException $e) {
            throw new FailToGenerateCsvException($e->getMessage(), $e->getCode(), $e);
        }
    }
}