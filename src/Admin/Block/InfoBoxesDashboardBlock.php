<?php

namespace App\Admin\Block;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

class InfoBoxesDashboardBlock extends AbstractBlockService
{
    private EntityManagerInterface $em;

    public function __construct(Environment $twig, EntityManagerInterface $em)
    {
        parent::__construct($twig);
        $this->em = $em;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null): Response
    {
        $settings = $blockContext->getSettings();
        $parameters = [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
            'total_pages_amount' => $this->em->getRepository(Page::class)->getTotalRecordsAmount(),
            'last_30_days_pages_amount' => $this->em->getRepository(Page::class)->getLast30DaysRecordsAmount(),
            'total_newsletters_amount' => 30,
            'last_30_days_newsletters_amount' => 40,
            'total_newsletter_users_amount' => 50,
            'last_30_days_newsletter_users_amount' => 60,
            'total_artists_amount' => 70,
            'last_30_days_artists_amount' => 80,
//            'total_accounts_amount' => $this->rm->getAr()->getTotalRecordsAmount(),
//            'last_30_days_accounts_amount' => $this->rm->getAr()->getLast30DaysRecordsAmount(),
//            'total_contacts_amount' => $this->rm->getCr()->getTotalRecordsAmount(),
//            'last_30_days_contacts_amount' => $this->rm->getCr()->getLast30DaysRecordsAmount(),
//            'total_proceedings_amount' => $this->rm->getPr()->getTotalRecordsAmount(),
//            'last_30_days_proceedings_amount' => $this->rm->getPr()->getLast30DaysRecordsAmount(),
//            'total_offers_amount' => $this->rm->getOfr()->getTotalRecordsAmount(),
//            'last_30_days_offers_amount' => $this->rm->getOfr()->getLast30DaysRecordsAmount(),
        ];

        return $this->renderResponse(
            $blockContext->getTemplate(),
            $parameters,
            $response
        );
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'title' => 'Infoboxes Header',
            'content' => 'Default content',
            'template' => 'backend/blocks/info_boxes_dashboard_block.html.twig',
        ]);
    }
}
