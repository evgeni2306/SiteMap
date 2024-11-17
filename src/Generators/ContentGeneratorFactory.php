<?php

declare(strict_types=1);

namespace Sitemap\Generators;

use Sitemap\Enums\FileTypeEnum;
use Sitemap\Exceptions\IncorrectFileTypeException;
use Sitemap\Interfaces\ContentGeneratorInterface;

final class ContentGeneratorFactory
{
    /**
     * @param string $fileType
     * @return ContentGeneratorInterface
     * @throws IncorrectFileTypeException
     */
    public static function factory(string $fileType): ContentGeneratorInterface
    {
        $fileType = strtoupper($fileType);

        return match ($fileType) {
            FileTypeEnum::XML->value => new XmlContentGenerator(),
            FileTypeEnum::JSON->value => new JsonContentGenerator(),
            FileTypeEnum::CSV->value => new CsvContentGenerator(),
            default => throw new IncorrectFileTypeException(),
        };
    }
}