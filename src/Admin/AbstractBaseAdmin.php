<?php

namespace App\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

abstract class AbstractBaseAdmin extends AbstractAdmin
{
    protected array $perPageOptions = [25, 50, 100, 200];
    protected int $maxPerPage = 25;
    protected EntityManagerInterface $em;
    protected Security $ss;
    protected Environment $twig;

    public function __construct($code, $class, $baseControllerName, EntityManagerInterface $em, Security $ss, Environment $twig)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
        $this->ss = $ss;
        $this->twig = $twig;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('show')
            ->remove('delete')
            ->remove('batch')
        ;
    }

    public function getExportFormats(): array
    {
        return [
            'csv',
            'xls',
        ];
    }

    protected function checkUserHasRole(string $role): bool
    {
        try {
            return $this->ss->isGranted($role);
        } catch (AuthenticationCredentialsNotFoundException $e) {
            return false;
        }
    }

    protected function hasLoggedUser(): bool
    {
        return (bool) $this->ss->getUser();
    }

    protected function getDefaultFormBoxArray(string $bootstrapGrid = 'md', string $bootstrapSize = '6', string $boxClass = 'primary'): array
    {
        return [
            'class' => 'col-'.$bootstrapGrid.'-'.$bootstrapSize,
            'box_class' => 'box box-'.$boxClass,
        ];
    }

    protected function getFormMdSuccessBoxArray(int $bootstrapColSize = 6): array
    {
        return $this->getDefaultFormBoxArray('md', (string) $bootstrapColSize, 'success');
    }

    protected function getShowMdInfoBoxArray(int $bootstrapColSize = 6, string $boxClass = 'info'): array
    {
        return [
            'class' => 'col-md-'.$bootstrapColSize,
            'box_class' => 'box box-'.$boxClass,
        ];
    }

    protected function isFormToCreateNewRecord(): bool
    {
        return !$this->id($this->getSubject());
    }

    protected function isChildForm(): bool
    {
        return $this->hasParentFieldDescription();
    }
}
