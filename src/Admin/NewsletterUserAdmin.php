<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Entity\NewsletterGroup;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add(
                'groups',
                null,
                [
                    'field_type' => EntityType::class,
                    'field_options' => [
                        'class' => NewsletterGroup::class,
                        'query_builder' => $this->em->getRepository(NewsletterGroup::class)->getAllSortedByName(),
                        'choice_label' => 'name',
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add('name')
            ->add('postalCode')
            ->add('phone')
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
            ->addIdentifier(
                'groups',
                null,
                [
                    'sortable' => true,
                    'associated_property' => 'name',
                    'sort_field_mapping' => ['fieldName' => 'name'],
                    'sort_parent_association_mappings' => [['fieldName' => 'groups']],
                    'editable' => false,
                ]
            )
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
                    'header_style' => 'width:81px',
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(5))
            ->add(
                'email',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false,
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
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'active',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
        ;
        if (!$this->isFormToCreateNewRecord()) {
            $form
                ->with('admin.common.information', $this->getFormMdSuccessBoxArray(4))
                ->add(
                    'groups',
                    EntityType::class,
                    [
                        'class' => NewsletterGroup::class,
                        'query_builder' => $this->em->getRepository(NewsletterGroup::class)->getAllSortedByName(),
                        'choice_label' => 'name',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'disabled' => 'disabled',
                        ],
                    ]
                )
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
                ->end()
            ;
        }
    }

    protected function configureExportFields(): array
    {
        return [
            'id',
            'createdAtString',
            'email',
            'groups',
            'name',
            'postalCode',
            'phone',
            'fail',
            'activeString',
            'updatedAtString',
        ];
    }
}
