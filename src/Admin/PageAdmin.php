<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use App\Entity\Translation\PageTranslation;
use App\Enum\PageTemplateTypeEnum;
use App\Enum\SortOrderTypeEnum;
use App\Form\Type\GedmoTranslationsType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class PageAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::DESC;
        $sortValues[DatagridInterface::SORT_BY] = 'publishDate';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('duplicate', $this->getRouterIdParameter().'/duplicate')
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
            ->add('id')
            ->add(
                'publishDate',
                DateFilter::class,
                [
                    'field_type' => DatePickerType::class,
                    'format' => AbstractBase::DATAGRID_TYPE_DATE_FORMAT,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractBase::DATAGRID_WIDGET_DATE_FORMAT,
                    ],
                ]
            )
            ->add('showPublishDate')
            ->add('keepAsPageEvenIfItsArchive')
            ->add('name')
            ->add('summary')
            ->add('description')
            ->add('place')
            ->add('video')
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
            ->add(
                'menuLevel2',
                null,
                [
                    'field_type' => EntityType::class,
                    'field_options' => [
                        'class' => MenuLevel2::class,
                        'query_builder' => $this->em->getRepository(MenuLevel2::class)->getAllSortedByPositionAndName(),
                        'choice_label' => 'hierarchyName',
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add(
                'templateType',
                ChoiceFilter::class,
                [
                    'field_type' => ChoiceType::class,
                    'field_options' => [
                        'choices' => PageTemplateTypeEnum::getReversedEnumArray(),
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add(
                'expirationDate',
                DateFilter::class,
                [
                    'field_type' => DatePickerType::class,
                    'format' => AbstractBase::DATAGRID_TYPE_DATE_FORMAT,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractBase::DATAGRID_WIDGET_DATE_FORMAT,
                    ],
                ]
            )
            ->add('realizationDateString')
            ->add('imageCaption')
            ->add('titleDocument1')
            ->add('titleDocument2')
            ->add('isFrontCover')
            ->add('showSocialNetworksSharingButtons')
            ->add('links')
            ->add('urlVimeo')
//            ->add('urlFlickr')
            ->add(
                'startDate',
                DateFilter::class,
                [
                    'field_type' => DatePickerType::class,
                    'format' => AbstractBase::DATAGRID_TYPE_DATE_FORMAT,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractBase::DATAGRID_WIDGET_DATE_FORMAT,
                    ],
                ]
            )
            ->add(
                'endDate',
                DateFilter::class,
                [
                    'field_type' => DatePickerType::class,
                    'format' => AbstractBase::DATAGRID_TYPE_DATE_FORMAT,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractBase::DATAGRID_WIDGET_DATE_FORMAT,
                    ],
                ]
            )
            ->add('alwaysShowOnCalendar')
            ->add(
                'active',
                null,
                [
                    'label' => 'filter.label_active_f',
                ]
            )
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'smallImage1FileName',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'template' => 'backend/cells/list__cell_page_small_image1.html.twig',
                    'sortable' => false,
                    'editable' => false,
                ]
            )
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
                'publishDate',
                FieldDescriptionInterface::TYPE_DATE,
                [
                    'format' => AbstractBase::DATE_FORMAT,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
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
            ->addIdentifier(
                'menuLevel2',
                null,
                [
                    'sortable' => true,
                    'associated_property' => 'name',
                    'sort_field_mapping' => ['fieldName' => 'name'],
                    'sort_parent_association_mappings' => [['fieldName' => 'menuLevel2']],
                    'editable' => false,
                ]
            )
            ->add(
                'templateType',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'template' => 'backend/cells/list__cell_page_template_type_field.html.twig',
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
                    'header_style' => 'width:112px',
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
                'place',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'video',
                UrlType::class,
                [
                    'required' => false,
                    'help' => 'form.label_video_help',
                ]
            )
            ->end()
            ->with('admin.common.dates', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'publishDate',
                DatePickerType::class,
                [
                    'format' => AbstractBase::FORM_TYPE_DATE_FORMAT,
                    'required' => true,
                ]
            )
            ->add(
                'showPublishDate',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'expirationDate',
                DatePickerType::class,
                [
                    'format' => AbstractBase::FORM_TYPE_DATE_FORMAT,
                    'help' => 'form.help_expiration_date',
                    'required' => false,
                ]
            )
            ->add(
                'realizationDateString',
                TextType::class,
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
                    'translatable_class' => PageTranslation::class,
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
                        'imageCaption' => [
                            'label' => 'form.label_image_caption',
                            'required' => false,
                            'field_type' => TextType::class,
                        ],
                    ],
                ]
            )
            ->end()
            ->with('admin.common.cover', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'smallImage1File',
                VichImageType::class,
                [
                    'imagine_pattern' => '300x300',
                    'required' => false,
                ]
            )
            ->add(
                'smallImage2File',
                VichImageType::class,
                [
                    'imagine_pattern' => '300x300',
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.images', $this->getFormMdSuccessBoxArray(8))
            ->add(
                'imageFile',
                VichImageType::class,
                [
                    'imagine_pattern' => '800xY',
                    'required' => false,
                ]
            )
            ->add(
                'imageCaption',
                TextType::class,
                [
                    'required' => false,
                ]
            )
        ;
        if (!$this->isFormToCreateNewRecord()) {
            $form
                ->add(
                    'images',
                    CollectionType::class,
                    [
                        'required' => false,
                        'error_bubbling' => true,
                        'by_reference' => false,
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                        'order' => SortOrderTypeEnum::ASC,
                    ]
                )
            ;
        }
        $form
            ->end()
            ->with('admin.common.documents', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'document1File',
                VichFileType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'titleDocument1',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'document2File',
                VichFileType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'titleDocument2',
                TextType::class,
                [
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
                    'required' => false,
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
                'previousEditions',
                EntityType::class,
                [
                    'class' => Page::class,
                    'query_builder' => $this->em->getRepository(Page::class)->getAllSortedByPublishDate(),
                    'choice_label' => 'humanReadableIdentifier',
                    'multiple' => true,
                    'required' => false,
                    'by_reference' => false,
                ]
            )
            ->add(
                'templateType',
                ChoiceType::class,
                [
                    'choices' => PageTemplateTypeEnum::getReversedEnumArray(),
                    'required' => true,
                ]
            )
            ->add(
                'isFrontCover',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'showSocialNetworksSharingButtons',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'keepAsPageEvenIfItsArchive',
                CheckboxType::class,
                [
                    'required' => false,
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
            ->with('admin.common.links', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'links',
                CKEditorType::class,
                [
                    'required' => false,
                    'config_name' => 'app_custom_half_height_config',
                    'attr' => [
                        'rows' => 5,
                    ],
                ]
            )
            ->add(
                'urlVimeo',
                TextType::class,
                [
                    'required' => false,
                    'help' => 'form.label_url_vimeo_help',
                ]
            )
//            ->add(
//                'urlFlickr',
//                TextType::class,
//                [
//                    'required' => false,
//                ]
//            )
            ->end()
            ->with('admin.common.calendar', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'startDate',
                DatePickerType::class,
                [
                    'format' => AbstractBase::FORM_TYPE_DATE_FORMAT,
                    'required' => false,
                ]
            )
            ->add(
                'endDate',
                DatePickerType::class,
                [
                    'format' => AbstractBase::FORM_TYPE_DATE_FORMAT,
                    'required' => false,
                ]
            )
            ->add(
                'alwaysShowOnCalendar',
                CheckboxType::class,
                [
                    'help' => 'form.help_always_show_on_calendar',
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
            'publishDateString',
            'showPublishDateString',
            'keepAsPageEvenIfItsArchiveString',
            'name',
            'summary',
            'description',
            'place',
            'video',
            'menuLevel1',
            'menuLevel2',
            'templateType',
            'expirationDateString',
            'realizationDateString',
            'imageCaption',
            'titleDocument1',
            'titleDocument2',
            'isFrontCoverString',
            'showSocialNetworksSharingButtons',
            'links',
            'urlVimeo',
//            'urlFlickr',
            'startDateString',
            'endDateString',
            'alwaysShowOnCalendarString',
            'showSocialNetworksSharingButtonsString',
            'activeString',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
