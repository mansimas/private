<?php

namespace Client\MedicalBundle\EventListener;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LanguageListener
{
    private $session;

    public function setSession(Session $session) {
        $this->session = $session;
    }

    public function setLocaleForUnauthenticatedUser(GetResponseEvent $event) {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        $locale = $request->getSession()->get('_locale');
        if (isset($locale) && $locale != '') {
            $request->setLocale($locale);
        } else {
            $request->setLocale('en');
        }
    }
}
