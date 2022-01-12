<?php

namespace App\Admin;

use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class VisitingHoursAdmin extends AbstractBaseAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->remove('create');
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'name';
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'name',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'textLine1',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'textLine2',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                ListMapper::NAME_ACTIONS,
                null,
                [
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'actions' => [
                        'edit' => [],
                    ],
                ]
            )
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray())
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'textLine1',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'textLine2',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
        ;
    }
}
