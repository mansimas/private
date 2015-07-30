<?php

namespace Clinic\CommunicationBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ForgotPassword
{
    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = false
     * )
     */
     public $email;
}