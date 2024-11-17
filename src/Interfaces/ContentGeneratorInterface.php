<?php

namespace Sitemap\Interfaces;

interface ContentGeneratorInterface
{
    function generate(array $pagesArr): string;
}
