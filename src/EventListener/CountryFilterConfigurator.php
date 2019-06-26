<?php


namespace App\EventListener;


use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CountryFilterConfigurator
{
    private $em;
    private $tokenStorage;
    private $reader;

    /**
     * CountryFilterConfigurator constructor.
     * @param $em
     * @param $tokenStorage
     * @param $reader
     */
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, Reader $reader)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->reader = $reader;
    }

    public function onKernelRequest(): void
    {
        if (!$user = $this->getUser()){
            throw new \RuntimeException("There is no authenticated user");
        }
        $filter = $this->em->getFilters()->enable('country_filter');
        $filter->setParameter('country', $user->getCountry());
        $filter->setAnnotationReader($this->reader);
    }

    private function getUser(): ?UserInterface
    {
        if(!$token = $this->tokenStorage->getToken()){
            return null;
        }

        $user = $token->getUser();
        return $user instanceof UserInterface ? $user : null;
    }


}