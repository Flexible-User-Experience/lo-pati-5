<?php

namespace App\Admin;

use App\Entity\Translation\ArtistTranslation;
use App\Enum\SortOrderTypeEnum;
use App\Form\Type\GedmoTranslationsType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class ArtistAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::ASC;
        $sortValues[DatagridInterface::SORT_BY] = 'name';
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

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name')
            ->add('category')
            ->add('city')
            ->add('webpage')
            ->add('year')
            ->add('summary')
            ->add('description')
            ->add('active')
        ;
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
                    'template' => 'backend/cells/list__cell_artist_image1.html.twig',
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
                'category',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'city',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'webpage',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'year',
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
                    'header_style' => 'width:111px',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'actions' => [
                        'edit' => [],
                        'pdf' => [
                            'template' => 'backend/actions/list__action_pdf_preview_button.html.twig',
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray(8))
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
            ->end()
            ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'category',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'city',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'webpage',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'year',
                NumberType::class,
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
            ->with('admin.common.translations', $this->getFormMdSuccessBoxArray(8))
            ->add(
                'translations',
                GedmoTranslationsType::class,
                [
                    'label' => false,
                    'required' => false,
                    'translatable_class' => ArtistTranslation::class,
                    'fields' => [
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
                    ],
                ]
            )
            ->end()
            ->with('admin.common.images', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'image1File',
                VichImageType::class,
                [
                    'imagine_pattern' => '800xY',
                    'required' => false,
                ]
            )
            ->add(
                'image2File',
                VichImageType::class,
                [
                    'imagine_pattern' => '800xY',
                    'required' => false,
                ]
            )
            ->add(
                'image3File',
                VichImageType::class,
                [
                    'imagine_pattern' => '800xY',
                    'required' => false,
                ]
            )
            ->add(
                'image4File',
                VichImageType::class,
                [
                    'imagine_pattern' => '800xY',
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.documents', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'document1File',
                VichFileType::class,
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
            'category',
            'city',
            'webpage',
            'year',
            'summary',
            'description',
            'year',
            'activeString',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
