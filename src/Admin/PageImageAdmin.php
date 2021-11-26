<?php

namespace App\Admin;

use App\Entity\Page;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class PageImageAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'id';
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
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
                'position',
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
                'image1File',
                VichImageType::class,
                [
                    'imagine_pattern' => '300x300',
                    'required' => false,
                ]
            )
            ->add(
                'imageAltName',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'page',
                EntityType::class,
                [
                    'class' => Page::class,
//                    'query_builder' => $this->em->getRepository(MenuLevel2::class)->getAllSortedByPositionAndName(),
//                    'choice_label' => 'hierarchyName',
                    'multiple' => false,
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
}
