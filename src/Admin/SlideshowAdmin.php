<?php

namespace App\Admin;

use App\Entity\Page;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class SlideshowAdmin extends AbstractBaseAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('show')
            ->remove('batch')
        ;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'position';
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'image1FileName',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'template' => 'backend/cells/list__cell_slideshow_image1.html.twig',
                    'sortable' => false,
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
            ->add(
                'link',
                null,
                [
                    'editable' => true,
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
                'page',
                EntityType::class,
                [
                    'class' => Page::class,
                    'query_builder' => $this->em->getRepository(Page::class)->getAllSortedByPublishDate(),
                    'multiple' => false,
                    'required' => true,
                    'attr' => [
                        'hidden' => true,
                    ],
                ]
            )
            ->end()
        ;
    }
}
