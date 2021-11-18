<?php

namespace App\Admin;

use App\Enum\SortOrderTypeEnum;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class ConfigFooterInformationAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'address';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('create')
            ->remove('export')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'address',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'timetable',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'organizer',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'collaborator',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(12))
            ->add(
                'address',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->add(
                'timetable',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->add(
                'organizer',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->add(
                'collaborator',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->end()
        ;
    }
}
