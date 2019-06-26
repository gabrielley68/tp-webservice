<?php


namespace App\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class CountryAware
{
    public $countryFieldName;
}