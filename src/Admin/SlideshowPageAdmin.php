<?php

namespace App\Admin;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Translation\SlideshowPageTranslation;
use App\Enum\SortOrderTypeEnum;
use App\Form\Type\GedmoTranslationsType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class SlideshowPageAdmin extends AbstractBaseAdmin
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
                'imageFileName',
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
                'summary',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'realizationDateString',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'place',
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(4))
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
                        'rows' => 5,
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
            ->add(
                'realizationDateString',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'place',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.translations', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'translations',
                GedmoTranslationsType::class,
                [
                    'label' => false,
                    'required' => false,
                    'translatable_class' => SlideshowPageTranslation::class,
                    'fields' => [
                        'name' => [
                            'label' => 'form.label_name',
                            'required' => false,
                            'field_type' => TextType::class,
                        ],
                        'summary' => [
                            'label' => 'form.label_summary',
                            'required' => false,
                            'field_type' => TextareaType::class,
                            'attr' => [
                                'rows' => 5,
                                'style' => 'resize:vertical',
                            ],
                        ],
                        'description' => [
                            'label' => 'form.label_description',
                            'required' => false,
                            'field_type' => CKEditorType::class,
                            'attr' => [
                                'rows' => 5,
                                'style' => 'resize:vertical',
                            ],
                        ],
                        'realizationDateString' => [
                            'label' => 'form.label_realization_date_string',
                            'required' => false,
                            'field_type' => TextType::class,
                        ],
                        'place' => [
                            'label' => 'form.label_place',
                            'required' => false,
                            'field_type' => TextType::class,
                        ],
                    ],
                ]
            )
            ->end()
            ->with('admin.common.images', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'imageFile',
                VichImageType::class,
                [
                    'imagine_pattern' => '800xY',
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(4))
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
                'link',
                UrlType::class,
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
                'active',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
        ;
    }
}
