<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Enum\NewsletterStatusEnum;
use App\Enum\SortOrderTypeEnum;
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
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class NewsletterAdmin extends AbstractBaseAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderTypeEnum::DESC;
        $sortValues[DatagridInterface::SORT_BY] = 'date';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('preview', $this->getRouterIdParameter().'/preview')
            ->add('test', $this->getRouterIdParameter().'/test')
            ->add('send', $this->getRouterIdParameter().'/send')
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
            ->add(
                'date',
                DateFilter::class,
                [
                    'label' => 'filter.label_created_at',
                    'field_type' => DatePickerType::class,
                    'format' => AbstractBase::DATAGRID_TYPE_DATE_FORMAT,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractBase::DATAGRID_WIDGET_DATE_FORMAT,
                    ],
                ]
            )
            ->add('subject')
            ->add('tested')
            ->add(
                'status',
                ChoiceFilter::class,
                [
                    'field_type' => ChoiceType::class,
                    'field_options' => [
                        'choices' => NewsletterStatusEnum::getReversedEnumArray(),
                        'multiple' => true,
                        'required' => false,
                    ],
                ]
            )
            ->add(
                'beginSend',
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
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'date',
                FieldDescriptionInterface::TYPE_DATE,
                [
                    'label' => 'list.label_created_at',
                    'format' => AbstractBase::DATE_FORMAT,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => true,
                ]
            )
            ->add(
                'subject',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'tested',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => false,
                ]
            )
            ->add(
                'status',
                null,
                [
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => false,
                    'template' => 'backend/cells/list__cell_newsletter_status_field.html.twig',
                ]
            )
            ->add(
                'beginSend',
                FieldDescriptionInterface::TYPE_DATE,
                [
                    'format' => AbstractBase::DATETIME_FORMAT,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => false,
                ]
            )
            ->add(
                ListMapper::NAME_ACTIONS,
                null,
                [
                    'header_style' => 'width:148px',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'actions' => [
                        'preview' => [
                            'template' => 'backend/actions/list__action_newsletter_email_preview_button.html.twig',
                        ],
                        'test' => [
                            'template' => 'backend/actions/list__action_newsletter_send_test_email_button.html.twig',
                        ],
                        'send' => [
                            'template' => 'backend/actions/list__action_newsletter_send_email_button.html.twig',
                        ],
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
            ->with('admin.common.general', $this->getFormMdSuccessBoxArray())
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
                'date',
                DatePickerType::class,
                [
                    'format' => AbstractBase::FORM_TYPE_DATE_FORMAT,
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.common.information', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'tested',
                CheckboxType::class,
                [
                    'disabled' => true,
                    'required' => false,
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'choices' => NewsletterStatusEnum::getReversedEnumArray(),
                    'disabled' => true,
                    'required' => false,
                ]
            )
            ->add(
                'beginSend',
                DateTimePickerType::class,
                [
                    'format' => AbstractBase::FORM_TYPE_DATETIME_FORMAT,
                    'disabled' => true,
                    'required' => false,
                ]
            )
            ->end();
        if (!$this->isFormToCreateNewRecord()) {
            $form
                ->with('admin.common.newsletter_posts', $this->getFormMdSuccessBoxArray(12))
                ->add(
                    'posts',
                    CollectionType::class,
                    [
                        'label' => ' ',
                        'error_bubbling' => true,
                        'required' => false,
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ]
                )
                ->end()
            ;
        }
    }

    protected function configureExportFields(): array
    {
        return [
            'id',
            'dateString',
            'subject',
            'testedString',
            'statusTransString',
            'beginSendString',
            'createdAtString',
            'updatedAtString',
        ];
    }
}
