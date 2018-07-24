<?php

declare(strict_types=1);

namespace Seacommerce\TwigSwiftCssInliner\Tests;

use PHPUnit\Framework\TestCase;
use Seacommerce\TwigSwiftCssInliner\CssInliner;
use Twig_Environment;
use Twig_Loader_Filesystem;

class CssInlinerTest extends TestCase
{
    /** @var Twig_Loader_Filesystem */
    private static $loader;

    /** @var Twig_Environment */
    private static $twig;

    /** @var string */
    private static $messageId;

    /** @var \DateTime */
    private static $messageDate;

    /** @var string */
    private static $messageBoundary;

    /** @var array */
    private static $viewData;

    public static function setUpBeforeClass()
    {
        self::$loader = new Twig_Loader_Filesystem(__DIR__ . '/Fixtures/templates/');
        self::$twig = new Twig_Environment(self::$loader);
        self::$messageId = 'adb9c4cf72fc807445f0d3cd4afc9db9@test.generated';
        self::$messageDate = new \DateTime('2013-09-28', new \DateTimeZone('utc'));
        self::$messageBoundary = '__test_phpunit_aWSqkye88HQhRMbg';
        self::$viewData = [
            'orderNbr' => 223423,
            'reference' => 'ABC12',
        ];
    }

    public function testAllBlocks()
    {
        $inliner = new CssInliner(self::$twig);
        $message = $inliner->createEmailFromTemplateFile('all-blocks.html.twig', self::$viewData)->setId(self::$messageId)->setDate(self::$messageDate)->setBoundary(self::$messageBoundary);
//        file_put_contents(__DIR__ . '/Fixtures/templates/all-blocks.expected.email', $message->toString());
        $this->assertStringEqualsFile(__DIR__ . '/Fixtures/templates/all-blocks.expected.email', $message->toString());
    }

    public function testHtmlBodyOnly()
    {
        $inliner = new CssInliner(self::$twig);

        $message = $inliner->createEmailFromTemplateFile('html-body-only.html.twig', self::$viewData)->setId(self::$messageId)->setDate(self::$messageDate)->setBoundary(self::$messageBoundary);
//        file_put_contents(__DIR__ . '/Fixtures/templates/html-body-only.expected.email', $message->toString());
        $this->assertStringEqualsFile(__DIR__ . '/Fixtures/templates/html-body-only.expected.email', $message->toString());
    }

    public function testTextBodyOnly()
    {
        $inliner = new CssInliner(self::$twig);
        $message = $inliner->createEmailFromTemplateFile('text-body-only.html.twig', self::$viewData)->setId(self::$messageId)->setDate(self::$messageDate)->setBoundary(self::$messageBoundary);
//        file_put_contents(__DIR__ . '/Fixtures/templates/text-body-only.expected.email', $message->toString());
        $this->assertStringEqualsFile(__DIR__ . '/Fixtures/templates/text-body-only.expected.email', $message->toString());
    }

    public function testSubjectOnly()
    {
        $inliner = new CssInliner(self::$twig);
        $message = $inliner->createEmailFromTemplateFile('subject-only.html.twig', self::$viewData)->setId(self::$messageId)->setDate(self::$messageDate)->setBoundary(self::$messageBoundary);
//        file_put_contents(__DIR__ . '/Fixtures/templates/subject-only.expected.email', $message->toString());
        $this->assertStringEqualsFile(__DIR__ . '/Fixtures/templates/subject-only.expected.email', $message->toString());
    }
}