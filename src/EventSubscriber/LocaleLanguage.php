<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleLanguage implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct(string $defaultLocale = "fr_FR")
    {
        $this->defaultLocale = $defaultLocale;
    }

    // Get the request on the event
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if(!$request->hasPreviousSession())
        {
            return;
        }

        if($locale = $request->attributes->get('_locale'))
        {
            $request->getSession()->set('_locale', $locale);
        }
        else
        {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    // Inscription to an event with a maximum priority (17) on the request
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 17]]
        ];
    }
}