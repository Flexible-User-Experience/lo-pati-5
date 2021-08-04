<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class NewsletterUserAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::DESC;
        $sortValues[DatagridInterface::SORT_BY] = 'createdAt';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add(
                'createdAt',
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
            ->add('email')
            ->add('name')
            ->add('postalCode')
            // TODO groups
            ->add('fail')
            ->add('active')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'createdAt',
                FieldDescriptionInterface::TYPE_DATETIME,
                [
                    'format' => AbstractBase::DATETIME_FORMAT,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                'email',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'name',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'postalCode',
                null,
                [
                    'editable' => true,
                ]
            )
            // TODO groups
            ->add(
                'fail',
                null,
                [
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'editable' => false,
                ]
            )
            ->add(
                'active',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'postalCode',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(3));
        if (!$this->isFormToCreateNewRecord()) {
            $form
                ->add(
                    'createdAt',
                    DatePickerType::class,
                    [
                        'format' => AbstractBase::FORM_TYPE_DATETIME_FORMAT,
                        'required' => false,
                        'attr' => [
                            'readonly' => 'readonly',
                        ],
                    ]
                )
                ->add(
                    'fail',
                    null,
                    [
                        'required' => false,
                        'attr' => [
                            'readonly' => 'readonly',
                        ],
                    ]
                )
            ;
        }
        $form
            ->add(
                'active',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
        ;
    }

    protected function configureExportFields(): array
    {
        return [
            'id',
            'name',
            'email',
            'active',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
