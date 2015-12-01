<?php

namespace MS\PHPMD\Tests\Unit\Symfony2;

use MS\PHPMD\Rule\Symfony2\ControllerMethodName;
use MS\PHPMD\Tests\Unit\AbstractApplyTest;

/**
 * Class ControllerMethodNameTest
 *
 * @package MS\PHPMD\Tests\Unit\Symfony2
 */
class ControllerMethodNameTest extends AbstractApplyTest
{
    /**
     * @covers MS\PHPMD\Rule\Symfony2\ControllerMethodName
     */
    public function testApplyNoConcreteClass()
    {
        $node = \Mockery::mock('PHPMD\Node\ClassNode');
        $node->shouldReceive('isAbstract')->andReturn(true);

        $this->assertRule($node, 0);
    }

    /**
     * @covers MS\PHPMD\Rule\Symfony2\ControllerMethodName
     */
    public function testApplyNoController()
    {
        $node = \Mockery::mock('PHPMD\Node\ClassNode');
        $node->shouldReceive('isAbstract')->andReturn(false);
        $node->shouldReceive('getImage')->andReturn('TestService');

        $this->assertRule($node, 0);
    }

    /**
     * @covers MS\PHPMD\Rule\Symfony2\ControllerMethodName
     */
    public function testApplyWithDirtyController()
    {
        $className = 'TestController';
        $validPublicMethodName = 'testAction';
        $notValidPublicMethodName = 'doSomething';
        $validPrivateMethodName = 'createMyAwesomeForm';

        $validPublicMethodNode = \Mockery::mock('PHPMD\Node\MethodNode');
        $validPublicMethodNode->shouldReceive('getImage')->andReturn($validPublicMethodName);
        $validPublicMethodNode->shouldReceive('getParentName')->andReturn($className);
        $validPublicMethodNode->shouldReceive('getName')->andReturn($validPublicMethodName);
        $validPublicMethodNode->shouldReceive('isPublic')->andReturn(true);

        $notValidPublicMethodNode = \Mockery::mock('PHPMD\Node\MethodNode');
        $notValidPublicMethodNode->shouldReceive('getImage')->andReturn($notValidPublicMethodName);
        $notValidPublicMethodNode->shouldReceive('getParentName')->andReturn($className);
        $notValidPublicMethodNode->shouldReceive('getName')->andReturn($notValidPublicMethodName);
        $notValidPublicMethodNode->shouldReceive('isPublic')->andReturn(true);

        $validPrivateMethodNode = \Mockery::mock('PHPMD\Node\MethodNode');
        $validPrivateMethodNode->shouldReceive('getImage')->andReturn($validPrivateMethodName);
        $validPrivateMethodNode->shouldReceive('getParentName')->andReturn($className);
        $validPrivateMethodNode->shouldReceive('getName')->andReturn($validPrivateMethodName);
        $validPrivateMethodNode->shouldReceive('isPublic')->andReturn(false);

        $classNode = \Mockery::mock('PHPMD\Node\ClassNode');
        $classNode->shouldReceive('isAbstract')->andReturn(false);
        $classNode->shouldReceive('getImage')->andReturn($className);
        $classNode->shouldReceive('getMethods')->andReturn([$validPublicMethodNode, $notValidPublicMethodNode, $validPrivateMethodNode]);

        $this->assertRule($classNode, 1);
    }

    /**
     * @return ControllerMethodName
     */
    protected function getRule()
    {
        return new ControllerMethodName();
    }
}
