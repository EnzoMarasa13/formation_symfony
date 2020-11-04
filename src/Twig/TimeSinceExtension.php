<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TimeSinceExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('time_since', [$this, 'getTimeSince']),
        ];
    }

    public function getTimeSince(\DateTime $date, $format="d/m/Y H:i")
    {
        $now = new \DateTime();
        $diff = $date->diff($now);

        if ($diff->days > 1) {
            return $date->format("d/m/Y H:i");
        }
        elseif ($diff->h > 1) {
            return $diff->h. "heures";
        }
        else {
            return $diff->i." minutes et ".$diff->s. " secondes ".$format;
        }
    }
}
