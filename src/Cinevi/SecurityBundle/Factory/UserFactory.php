<?php

namespace Cinevi\SecurityBundle\Factory;

class UserFactory
{
    public static function createNewsletterManager()
    {
        $newsletterManager = new NewsletterManager();

        // ...

        return $newsletterManager;
    }
}
