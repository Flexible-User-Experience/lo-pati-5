<?php

namespace App\Admin;

use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class MenuLevel1Admin extends AbstractBaseAdmin
{
    protected array $datagridValues = [
        '_sort_by' => 'name',
        '_sort_order' => SortOrderTypeEnum::ASC,
    ];

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name')
            ->add('active')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
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
                    'label' => 'admin.action',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'actions' => [
                        'edit' => [],
//                        'edit' => [
//                            'template' => 'buttons/list__action_edit_button.html.twig',
//                        ],
//                        'delete' => [
//                            'template' => 'buttons/list__action_super_admin_delete_button.html.twig',
//                        ],
                    ],
                ]
            )
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class)
            ->add(
                'active',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
        ;
    }

    protected function configureExportFields(): array
    {
        return [
            'id',
            'name',
            'active',
//            'createdAtString',
//            'updatedAtString',
        ];
    }
}
