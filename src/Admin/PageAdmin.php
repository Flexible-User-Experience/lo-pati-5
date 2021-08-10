<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Enum\PageTemplateTypeEnum;
use App\Enum\SortOrderTypeEnum;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PageAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::DESC;
        $sortValues[DatagridInterface::SORT_BY] = 'publishDate';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('duplicate', $this->getRouterIdParameter().'/duplicate')
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
            ->add('id')
            ->add(
                'publishDate',
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
            ->add('name')
            ->add(
                'menuLevel1',
                null,
                [
                    'field_type' => EntityType::class,
                    'field_options' => [
                        'class' => MenuLevel1::class,
                        'query_builder' => $this->em->getRepository(MenuLevel1::class)->getAllSortedByPositionAndName(),
                        'choice_label' => 'name',
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add(
                'menuLevel2',
                null,
                [
                    'field_type' => EntityType::class,
                    'field_options' => [
                        'class' => MenuLevel2::class,
                        'query_builder' => $this->em->getRepository(MenuLevel2::class)->getAllSortedByPositionAndName(),
                        'choice_label' => 'hierarchyName',
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add(
                'templateType',
                ChoiceFilter::class,
                [
                    'field_type' => ChoiceType::class,
                    'field_options' => [
                        'choices' => PageTemplateTypeEnum::getReversedEnumArray(),
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add(
                'active',
                null,
                [
                    'label' => 'filter.label_active_f',
                ]
            )
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'smallImage1FileName',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'template' => 'backend/cells/list__cell_page_small_image1.html.twig',
                    'sortable' => false,
                    'editable' => false,
                ]
            )
            ->add(
                'id',
                null,
                [
                    'accessor' => 'idString',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'editable' => false,
                ]
            )
            ->add(
                'publishDate',
                FieldDescriptionInterface::TYPE_DATE,
                [
                    'format' => AbstractBase::DATE_FORMAT,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'editable' => true,
                ]
            )
            ->addIdentifier(
                'menuLevel1',
                null,
                [
                    'sortable' => true,
                    'associated_property' => 'name',
                    'sort_field_mapping' => ['fieldName' => 'name'],
                    'sort_parent_association_mappings' => [['fieldName' => 'menuLevel1']],
                    'editable' => false,
                ]
            )
            ->addIdentifier(
                'menuLevel2',
                null,
                [
                    'sortable' => true,
                    'associated_property' => 'name',
                    'sort_field_mapping' => ['fieldName' => 'name'],
                    'sort_parent_association_mappings' => [['fieldName' => 'menuLevel2']],
                    'editable' => false,
                ]
            )
            ->add(
                'templateType',
                FieldDescriptionInterface::TYPE_CHOICE,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => true,
                ]
            )
            ->add(
                'active',
                null,
                [
                    'label' => 'list.label_active_f',
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
                        'duplicate' => [
                            'template' => 'backend/actions/list__action_page_duplicate.html.twig',
                        ],
                        'delete' => [],
                    ],
                ]
            )
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(8))
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'summary',
                TextareaType::class,
                [
                    'required' => false,
                    'help' => 'form.help_short_description_length',
                    'attr' => [
                        'rows' => 8,
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->add(
                'description',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'publishDate',
                DatePickerType::class,
                [
                    'format' => AbstractBase::FORM_TYPE_DATE_FORMAT,
                    'required' => false,
                ]
            )
            ->add(
                'menuLevel1',
                EntityType::class,
                [
                    'class' => MenuLevel1::class,
                    'query_builder' => $this->em->getRepository(MenuLevel1::class)->getAllSortedByPositionAndName(),
                    'choice_label' => 'name',
                    'multiple' => false,
                    'required' => false,
                ]
            )
            ->add(
                'menuLevel2',
                EntityType::class,
                [
                    'class' => MenuLevel2::class,
                    'query_builder' => $this->em->getRepository(MenuLevel2::class)->getAllSortedByPositionAndName(),
                    'choice_label' => 'hierarchyName',
                    'multiple' => false,
                    'required' => false,
                ]
            )
            ->add(
                'templateType',
                ChoiceType::class,
                [
                    'choices' => PageTemplateTypeEnum::getReversedEnumArray(),
                    'required' => true,
                ]
            )
            ->add(
                'active',
                CheckboxType::class,
                [
                    'label' => 'form.label_active_f',
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
            'activeString',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
