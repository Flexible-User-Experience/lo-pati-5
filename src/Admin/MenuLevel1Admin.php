<?php

namespace App\Admin;

use App\Entity\Page;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                    'field_type' => EntityType::class,
                    'field_options' => [
                        'class' => Page::class,
                        'query_builder' => $this->em->getRepository(Page::class)->getAllSortedByName(),
                        'choice_label' => 'name',
                        'multiple' => false,
                        'required' => true,
                    ],
                ]
            )
            ->add('position')
            ->add('active')
        ;
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
            ->addIdentifier(
                'page',
                null,
                [
                    'sortable' => true,
                    'associated_property' => 'name',
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
                    'required' => true,
                ]
            )
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'page',
                EntityType::class,
                [
                    'class' => Page::class,
                    'query_builder' => $this->em->getRepository(Page::class)->getAllSortedByName(),
                    'choice_label' => 'name',
                    'multiple' => false,
                    'required' => false,
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
            'page',
            'position',
            'active',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
