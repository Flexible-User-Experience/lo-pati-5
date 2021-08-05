<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class NewsletterAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::DESC;
        $sortValues[DatagridInterface::SORT_BY] = 'date';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('show')
            ->remove('batch')
        ;
    }

    public function configureBatchActions(array $actions): array
    {
        unset($actions['delete']);

        return $actions;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add(
                'date',
                DateFilter::class,
                [
                    'label' => 'filter.label_created_at',
                    'field_type' => DatePickerType::class,
                    'format' => AbstractBase::DATAGRID_TYPE_DATE_FORMAT,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractBase::DATAGRID_WIDGET_DATE_FORMAT,
                    ],
                ]
            )
            ->add('subject')
            ->add('tested')
            ->add('status') // TODO
            ->add(
                'beginSend',
                DateFilter::class,
                [
                    'field_type' => DatePickerType::class,
                    'format' => AbstractBase::DATAGRID_TYPE_DATE_FORMAT,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractBase::DATAGRID_WIDGET_DATE_FORMAT,
                    ],
                ]
            )
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'date',
                FieldDescriptionInterface::TYPE_DATE,
                [
                    'label' => 'list.label_created_at',
                    'format' => AbstractBase::DATE_FORMAT,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                'subject',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'tested',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => true,
                ]
            )
            ->add(
                'status',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => false,
                    'template' => 'backend/cells/list__cell_newsletter_status_field.html.twig',
                ]
            )
            ->add(
                'beginSend',
                FieldDescriptionInterface::TYPE_DATE,
                [
                    'format' => AbstractBase::DATETIME_FORMAT,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
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
                        'delete' => [],
                    ],
                ]
            )
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'subject',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(3))
//            ->add(
//                'active',
//                CheckboxType::class,
//                [
//                    'required' => false,
//                ]
//            )
            ->end()
        ;
    }

    protected function configureExportFields(): array
    {
        return [
            'id',
            'name',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
