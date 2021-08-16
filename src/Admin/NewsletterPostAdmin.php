<?php

namespace App\Admin;

use App\Entity\AbstractBase;
use App\Enum\NewsletterTypeEnum;
use App\Enum\SortOrderTypeEnum;
use App\Form\Type\EditNewsletterPostActionButtonFormType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
        if ($this->getRootCode() !== $this->getCode()) {
            // embeded in NewsletterAdmin inline table edit view
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
                    NumberType::class,
                    [
                        'required' => true,
                    ]
                )
            ;
            if (!$this->isFormToCreateNewRecord()) {
                $form
                    ->add(
                        'fakeAction',
                        EditNewsletterPostActionButtonFormType::class,
                        [
                            'text' => $this->getTranslator()->trans('back.action.edit'),
                            'url' => $this->generateObjectUrl('edit', $this->getSubject()),
                            'label' => $this->getTranslator()->trans('list.label__actions'),
                            'mapped' => false,
                            'required' => false,
                        ]
                    )
                ;
            }
            $form->end();
        } else {
            // normal admin view
            $form
                ->with('admin.common.general', $this->getFormMdSuccessBoxArray())
                ->add(
                    'title',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'shortDescription',
                    TextareaType::class,
                    [
                        'label' => 'form.label_summary',
                        'required' => false,
                        'attr' => [
                            'rows' => 5,
                            'style' => 'resize:vertical',
                        ],
                    ]
                )
                ->end()
                ->with('admin.common.dates', $this->getFormMdSuccessBoxArray(3))
                ->add(
                    'date',
                    DatePickerType::class,
                    [
                        'label' => 'form.label_begin_date',
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
                    'intervalDateText',
                    TextType::class,
                    [
                        'required' => false,
                        'help' => 'form.label_interval_date_text_help',
                    ]
                )
                ->end()
                ->with('admin.common.controls', $this->getFormMdSuccessBoxArray(3))
                ->add(
                    'type',
                    ChoiceType::class,
                    [
                        'choices' => NewsletterTypeEnum::getReversedEnumArray(),
                        'required' => false,
                    ]
                )
                ->add(
                    'location',
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
                ->end()
                ->with('admin.common.images', $this->getFormMdSuccessBoxArray())
                ->add(
                    'image1File',
                    VichImageType::class,
                    [
                        'imagine_pattern' => '800xY',
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
                ->end()
            ;
        }
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
