<?php

/**
 * @author    David Anatoly <david221189av@gmail.com>
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @link      https://terranet.md/
 * @version   1.0.0
 */

namespace TranslateFileManager\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    private $isWebUIEnabled;

    public function __construct(
        bool $isWebUIEnabled = null
    )
    {
        $this->isWebUIEnabled = $isWebUIEnabled;
    }

    public function indexAction()
    {
        if (!$this->isWebUIEnabled) {
            return new Response('You are not allowed here. Check your config.', Response::HTTP_BAD_REQUEST);
        }

        return new Response('test response');
    }
}