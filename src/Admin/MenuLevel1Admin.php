<?php

namespace App\Admin;

use App\Entity\Page;
use App\Entity\Translation\MenuLevel1Translation;
use App\Enum\SortOrderTypeEnum;
use App\Form\Type\GedmoTranslationsType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class MenuLevel1Admin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'position';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name')
            ->add(
                'page',
                null,
                [
                    'label' => 'filter.label_related_page',
                    'field_type' => EntityType::class,
                    'field_options' => [
                        'class' => Page::class,
                        'query_builder' => $this->em->getRepository(Page::class)->getAllSortedByPublishDate(),
                        'choice_label' => 'humanReadableIdentifier',
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add('position')
            ->add('isArchive')
            ->add('active')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'color',
                null,
                [
                    'editable' => true,
                    'template' => 'backend/cells/list__cell_menu_level1_color.html.twig',
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
                'page',
                null,
                [
                    'label' => 'list.label_related_page',
                    'sortable' => true,
                    'associated_property' => 'humanReadableIdentifier',
                    'sort_field_mapping' => ['fieldName' => 'name'],
                    'sort_parent_association_mappings' => [['fieldName' => 'page']],
                    'editable' => false,
                ]
            )
            ->add(
                'position',
                null,
                [
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'editable' => true,
                ]
            )
            ->add(
                'isArchive',
                null,
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
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => true,
                ]
            )
            ->add(
                ListMapper::NAME_ACTIONS,
                null,
                [
                    'header_style' => 'width:63px',
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(5))
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'page',
                EntityType::class,
                [
                    'label' => 'form.label_related_page',
                    'class' => Page::class,
                    'query_builder' => $this->em->getRepository(Page::class)->getAllSortedByPublishDate(),
                    'choice_label' => 'humanReadableIdentifier',
                    'multiple' => false,
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'color',
                ColorType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'position',
                NumberType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'isArchive',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'active',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.translations', $this->getFormMdSuccessBoxArray(5))
            ->add(
                'translations',
                GedmoTranslationsType::class,
                [
                    'label' => false,
                    'required' => false,
                    'translatable_class' => MenuLevel1Translation::class,
                    'fields' => [
                        'name' => [
                            'label' => 'form.label_name',
                            'required' => false,
                            'field_type' => TextType::class,
                        ],
                    ],
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
            'page.humanReadableIdentifier',
            'position',
            'isArchiveString',
            'activeString',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
