<?php


namespace App\Filter;


use App\Annotations\CountryAware;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class CountryFilter extends SQLFilter
{
    private $reader;

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if(null === $this->reader) {
            throw new \RuntimeException(sprintf('An annotation reader must be provided. Be sure to call"%s::setAnnotationReader()".', __CLASS__));
        }

        $countryAware = $this->reader->getClassAnnotation($targetEntity->getReflectionClass(), CountryAware::class);
        if(!$countryAware){
            return '';
        }

        $fieldname = $countryAware->countryFieldName;

        try {
            $country = $this->getParameter('country');
        } catch (\InvalidArgumentException $e){
            return '';
        }

        if(empty($fieldname) || empty($country)){
            return '';
        }
        return sprintf('%s.%s = %s', $targetTableAlias, $fieldname, $country);
    }

    public function setAnnotationReader($reader): void
    {
        $this->reader = $reader;
    }
}