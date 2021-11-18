<?php

namespace App\Admin;

use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class ConfigCalendarWorkingDayAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'workingDayNumber';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('create')
            ->remove('update')
            ->remove('export')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'name',
                FieldDescriptionInterface::TYPE_STRING,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'active',
                null,
                [
                    'label' => 'list.label_active',
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => true,
                ]
            )
        ;
    }
}
