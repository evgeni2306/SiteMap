<?php

declare(strict_types=1);

namespace Sitemap;

use DateTime;
use Sitemap\Enums\ChangefreqEnum;
use Sitemap\Exceptions\FileSavingFailedException;
use Sitemap\Exceptions\IncorrectChangefreqValueException;
use Sitemap\Exceptions\IncorrectFileTypeException;
use Sitemap\Exceptions\IncorrectInputDataException;
use Sitemap\Exceptions\IncorrectLocValueException;
use Sitemap\Exceptions\IncorrectPriorityValueException;
use Sitemap\Exceptions\IncorrectTimeFormatException;
use Sitemap\Generators\ContentGeneratorFactory;

final class SiteMapGenerator
{
    /**
     * @param string $fileType
     * @param string $wayToSave
     * @param array $pagesArr
     * @param string $fileName
     * @throws FileSavingFailedException
     * @throws IncorrectChangefreqValueException
     * @throws IncorrectFileTypeException
     * @throws IncorrectInputDataException
     * @throws IncorrectPriorityValueException
     * @throws IncorrectTimeFormatException
     */
    public static function generate(string $fileType, string $wayToSave, array $pagesArr, string $fileName): void
    {
        self::validateArr($pagesArr);
        $fileGenerator = ContentGeneratorFactory::factory($fileType);
        $fileContent = $fileGenerator->generate($pagesArr);
        self::saveFile($fileType, $wayToSave, $fileContent, $fileName);
    }

    /**
     * @param string $fileType
     * @param string $wayToSave
     * @param string $fileContent
     * @param string $fileName
     * @return void
     * @throws FileSavingFailedException
     */
    private static function saveFile(string $fileType, string $wayToSave, string $fileContent, string $fileName): void
    {
        $savePath = $wayToSave . '/' . $fileName . '.' . strtolower($fileType);
        if (!file_exists($wayToSave)) {
            mkdir($wayToSave, 0777, true);
        }
        if (!file_put_contents($savePath, $fileContent)) {
            throw new FileSavingFailedException();
        };
    }

    /**
     * @param array $pagesArr
     * @throws IncorrectChangefreqValueException
     * @throws IncorrectInputDataException
     * @throws IncorrectPriorityValueException
     * @throws IncorrectTimeFormatException
     */
    private static function validateArr(array $pagesArr): void
    {
        foreach ($pagesArr as $arr) {

            if (count($arr) !== 4 && !isset($arr['loc'], $arr['lastmod'], $arr['priority'], $arr['changefreq'])) {
                throw new IncorrectInputDataException();
            }
            if (!filter_var($arr['loc'], FILTER_VALIDATE_URL)) {
                throw new IncorrectLocValueException();
            }
            if (ChangefreqEnum::tryFrom($arr['changefreq']) === null) {
                throw new IncorrectChangefreqValueException();
            }
            $date = new DateTime($arr['lastmod']);
            if ($date->format('Y-m-d') !== $arr['lastmod']) {
                throw new IncorrectTimeFormatException();
            }
            if (!(is_float($arr['priority']) && $arr['priority'] >= 0.0 && $arr['priority'] <= 1.0)) {
                throw new IncorrectPriorityValueException();
            }
        }
    }
}