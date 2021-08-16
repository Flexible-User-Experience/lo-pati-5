<?php

namespace App\Admin\Block;

use App\Entity\Artist;
use App\Entity\Newsletter;
use App\Entity\NewsletterUser;
use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

final class InfoBoxesDashboardBlock extends AbstractBlockService
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
            'total_newsletters_amount' => $this->em->getRepository(Newsletter::class)->getTotalRecordsAmount(),
            'last_30_days_newsletters_amount' => $this->em->getRepository(Newsletter::class)->getLast30DaysRecordsAmount(),
            'total_newsletter_users_amount' => $this->em->getRepository(NewsletterUser::class)->getTotalRecordsAmount(),
            'last_30_days_newsletter_users_amount' => $this->em->getRepository(NewsletterUser::class)->getLast30DaysRecordsAmount(),
            'total_artists_amount' => $this->em->getRepository(Artist::class)->getTotalRecordsAmount(),
            'last_30_days_artists_amount' => $this->em->getRepository(Artist::class)->getLast30DaysRecordsAmount(),
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
