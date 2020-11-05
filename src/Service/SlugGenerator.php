<?php


namespace App\Service;


use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;

class SlugGenerator implements SluggerInterface
{
    public function __construct(Security $security)
    {
        /** @var UserInterface $user */
        $user = $security->getToken();

    }

    public function slug(string $string, string $separator = '-', string $locale = null): AbstractUnicodeString
    {
        $slug = $this->slugify($string);
        return new UnicodeString($slug);
    }


    public function slugify($string) {
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
        $clean = trim($clean, '-');
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }
}