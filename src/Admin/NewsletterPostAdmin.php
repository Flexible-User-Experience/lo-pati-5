<?php

namespace App\Admin;

use App\Enum\NewsletterTypeEnum;
use App\Enum\SortOrderTypeEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class NewsletterPostAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'position';
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

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'title',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'position',
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'image1File',
                VichImageType::class,
                [
                    'imagine_pattern' => '800xY',
                    'required' => false,
                ]
            )
            ->add(
                'title',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => NewsletterTypeEnum::getReversedEnumArray(),
                    'required' => false,
                ]
            )
            ->add(
                'position',
                TextType::class,
                [
                    'required' => true,
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
