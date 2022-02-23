<?php

namespace App\Twig;

use App\Entity\AbstractBase;
use App\Entity\Newsletter;
use App\Entity\Page;
use App\Entity\User;
use App\Enum\NewsletterStatusEnum;
use App\Enum\PageTemplateTypeEnum;
use App\Enum\UserRolesEnum;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class AppRuntime implements RuntimeExtensionInterface
{
    private UploaderHelper $vuh;
    private CacheManager $lcm;
    private ParameterBagInterface $pb;
    private TranslatorInterface $ts;

    public function __construct(UploaderHelper $vuh, CacheManager $lcm, ParameterBagInterface $pb, TranslatorInterface $ts)
    {
        $this->vuh = $vuh;
        $this->lcm = $lcm;
        $this->pb = $pb;
        $this->ts = $ts;
    }

    // Tests
    public function isInstanceOf($var, $instance): bool
    {
        return (new ReflectionClass($instance))->isInstance($var);
    }

    // Functions
    public function isHighlitedImageSquared(Page $page): bool
    {
        $fieldName = 'imageFile';
        $isSquared = false;
        if ($page->getImageFileName()) {
            $fieldName = 'smallImage1File';
        }
        $imagefile = $this->vuh->asset($page, $fieldName, Page::class);
        [$width, $height] = getimagesize($this->getPublicProjectDir().$imagefile);
        if ($width > 0 && $height > 0 && $width === $height) {
            $isSquared = true;
        }

        return $isSquared;
    }

    public function getHighlitedImageFilter(Page $page): string
    {
        $fieldName = 'imageFile';
        $filter = '758x428';
        if ($page->getImageFileName()) {
            $fieldName = 'smallImage1File';
        }
        $imagefile = $this->vuh->asset($page, $fieldName, Page::class);
        [$width, $height] = getimagesize($this->getPublicProjectDir().$imagefile);
        if ($width > 0 && $height > 0 && $width === $height) {
            $filter = '758x758_fixed';
        }

        return $this->lcm->getBrowserPath($imagefile, $filter);
    }

    // Filters
    public function drawPageTemplateTypeHtmlSpan(Page $page): string
    {
        $class = 'default';
        if (PageTemplateTypeEnum::DEFAULT === $page->getTemplateType()) {
            $class = 'info';
        } elseif (PageTemplateTypeEnum::BLOG === $page->getTemplateType()) {
            $class = 'warning';
        } elseif (PageTemplateTypeEnum::INFO === $page->getTemplateType()) {
            $class = 'success';
        }

        return '<span class="label label-'.$class.'">'.$this->ts->trans($page->getTemplateTypeTransString()).'</span>';
    }

    public function drawNewsletterStatusHtmlSpan(Newsletter $newsletter): string
    {
        $class = 'default';
        $text = AbstractBase::DEFAULT_EMPTY_STRING;
        if (NewsletterStatusEnum::WAITING === $newsletter->getStatus()) {
            $class = 'info';
            $text = '<i class="fa fa-clock-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        } elseif (NewsletterStatusEnum::SENDING === $newsletter->getStatus()) {
            $class = 'warning';
            $text = '<i class="fa fa-paper-plane-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        } elseif (NewsletterStatusEnum::SENDED === $newsletter->getStatus()) {
            $class = 'success';
            $text = '<i class="fa fa-check-square-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        }

        return '<span class="label label-'.$class.'">'.$text.'</span>';
    }

    public function drawUserRolesHtmlSpan(User $user): string
    {
        $span = '';
        if (count($user->getRoles()) > 0) {
            $ea = UserRolesEnum::getEnumArray();
            /** @var string $role */
            foreach ($user->getRoles() as $role) {
                if (UserRolesEnum::ROLE_ADMIN === $role) {
                    $span .= '<span class="label label-info" style="margin-right:10px">'.$this->ts->trans($ea[UserRolesEnum::ROLE_ADMIN]).'</span>';
                } elseif (UserRolesEnum::ROLE_SUPER_ADMIN === $role) {
                    $span .= '<span class="label label-warning" style="margin-right:10px">'.$this->ts->trans($ea[UserRolesEnum::ROLE_SUPER_ADMIN]).'</span>';
                }
            }
        } else {
            $span = '<span class="label label-default" style="margin-right:10px">'.AbstractBase::DEFAULT_EMPTY_STRING.'</span>';
        }

        return $span;
    }

    public function integerNumberFormattedString(int $value): string
    {
        return number_format($value, 0, '\'', '.');
    }

    public function floatNumberFormattedString(float $value): string
    {
        return number_format($value, 2, '\'', '.');
    }

    private function getPublicProjectDir(): string
    {
        return $this->pb->get('kernel.project_dir').DIRECTORY_SEPARATOR.'public';
    }
}
