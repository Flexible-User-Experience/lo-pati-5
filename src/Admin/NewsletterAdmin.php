<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class NewsletterAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::DESC;
        $sortValues[DatagridInterface::SORT_BY] = 'date';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('subject')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'date',
                FieldDescriptionInterface::TYPE_DATE,
                [
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
//            ->add(
//                'active',
//                null,
//                [
//                    'header_class' => 'text-center',
//                    'row_align' => 'center',
//                    'editable' => true,
//                ]
//            )
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
                'subject',
                TextType::class,
                [
                    'required' => true,
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
    }

    protected function configureExportFields(): array
    {
        return [
            'id',
            'name',
            'active',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
