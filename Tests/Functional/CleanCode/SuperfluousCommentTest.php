<?php

namespace MS\PHPMD\Tests\Functional\CleanCode;

use MS\PHPMD\Tests\Functional\AbstractProcessTest;

/**
 * Class SuperfluousCommentTest
 *
 * @package MS\PHPMD\Tests\Functional\CleanCode
 */
class SuperfluousCommentTest extends AbstractProcessTest
{
    /**
     * @covers MS\PHPMD\Rule\CleanCode\SuperfluousComment
     */
    public function testSuperfluousCommentRule()
    {
        $output = $this
            ->runPhpmd('Service/SuperfluousComment.php', 'cleancode.xml')
            ->getOutput();

        $this->assertNotContains('SuperfluousComment.php:42	It seems', $output);

        $this->assertContains('SuperfluousComment.php:10	It seems that the class has a superfluous comment description. It fits 88 percent with the name of that.', $output);
        $this->assertContains('SuperfluousComment.php:10	It seems that the property $name has a superfluous comment description. It fits 73 percent with the name of that.', $output);
        $this->assertContains('SuperfluousComment.php:24	It seems that the method has a superfluous comment description. It fits 100 percent with the name of that.', $output);
        $this->assertContains('SuperfluousComment.php:34	It seems that the method has a superfluous comment description. It fits 82 percent with the name of that.', $output);
    }
}
