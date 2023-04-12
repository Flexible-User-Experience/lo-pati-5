<?php

namespace App\Admin;

use App\Entity\MenuLevel1;
use App\Entity\Page;
use App\Entity\Translation\MenuLevel2Translation;
use App\Enum\SortOrderTypeEnum;
use App\Form\Type\GedmoTranslationsType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class MenuLevel2Admin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'menuLevel1.position';
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        $rootAlias = current($query->getRootAliases());
        $query->addOrderBy($rootAlias.'.position', SortOrderTypeEnum::ASC);
        $query->addOrderBy($rootAlias.'.name', SortOrderTypeEnum::ASC);

        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
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
            ->add('isList')
            ->add('active')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
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
                'isList',
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
                'menuLevel1',
                EntityType::class,
                [
                    'class' => MenuLevel1::class,
                    'query_builder' => $this->em->getRepository(MenuLevel1::class)->getAllSortedByPositionAndName(),
                    'choice_label' => 'name',
                    'multiple' => false,
                    'required' => true,
                ]
            )
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
                    'label' => 'list.label_related_page',
                    'class' => Page::class,
                    'query_builder' => $this->em->getRepository(Page::class)->getAllSortedByName(),
                    'choice_label' => 'name',
                    'multiple' => false,
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'position',
                NumberType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'isList',
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
                    'translatable_class' => MenuLevel2Translation::class,
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
            'menuLevel1',
            'name',
            'page.humanReadableIdentifier',
            'position',
            'isListString',
            'activeString',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
