<?php

namespace App\Admin;

use App\Entity\Translation\ArtistTranslation;
use App\Enum\SortOrderTypeEnum;
use App\Form\Type\GedmoTranslationsType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

// NOT enabled, unnecessary admin
final class ConfigFooterInformationAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'address';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('create')
            ->remove('export')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'address',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'timetable',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'organizer',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'collaborator',
                FieldDescriptionInterface::TYPE_HTML,
                [
                    'editable' => false,
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray())
            ->add(
                'address',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->add(
                'timetable',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->add(
                'organizer',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->add(
                'collaborator',
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->end()
            ->with('admin.common.translations', $this->getFormMdSuccessBoxArray())
            ->add(
                'translations',
                GedmoTranslationsType::class,
                [
                    'label' => false,
                    'required' => false,
                    'translatable_class' => ArtistTranslation::class,
                    'fields' => [
                        'address' => [
                            'label' => 'form.label_address',
                            'required' => false,
                            'field_type' => CKEditorType::class,
                            'attr' => [
                                'rows' => 5,
                                'style' => 'resize:vertical',
                            ],
                        ],
                        'timetable' => [
                            'label' => 'form.label_timetable',
                            'required' => false,
                            'field_type' => CKEditorType::class,
                            'attr' => [
                                'rows' => 5,
                                'style' => 'resize:vertical',
                            ],
                        ],
                        'organizer' => [
                            'label' => 'form.label_organizer',
                            'required' => false,
                            'field_type' => CKEditorType::class,
                            'attr' => [
                                'rows' => 5,
                                'style' => 'resize:vertical',
                            ],
                        ],
                        'collaborator' => [
                            'label' => 'form.label_collaborator',
                            'required' => false,
                            'field_type' => CKEditorType::class,
                            'attr' => [
                                'rows' => 5,
                                'style' => 'resize:vertical',
                            ],
                        ],
                    ],
                ]
            )
            ->end()
        ;
    }
}
