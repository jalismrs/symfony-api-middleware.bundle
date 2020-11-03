<?php
declare(strict_types = 1);

namespace Tests;

use Jalismrs\Symfony\Bundle\JalismrsApiMiddlewareBundle\ConvertJsonRequestMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class ConvertJsonRequestMiddlewareTest
 *
 * @package Tests
 *
 * @covers  \Jalismrs\Symfony\Bundle\JalismrsApiMiddlewareBundle\ConvertJsonRequestMiddleware
 */
final class ConvertJsonRequestMiddlewareTest extends
    TestCase
{
    /**
     * testLogger
     *
     * @var \Psr\Log\Test\TestLogger
     */
    private TestLogger $testLogger;

    /**
     * testOnKernelRequest
     *
     * @param array $providedInput
     * @param array $providedOutput
     *
     * @return void
     *
     * @throws \LogicException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Symfony\Component\HttpFoundation\Exception\BadRequestException
     *
     * @dataProvider \Tests\ConvertJsonRequestMiddlewareProvider::provideOnKernelRequest
     */
    public function testOnKernelRequest(
        array $providedInput,
        array $providedOutput
    ) : void {
        // arrange
        $systemUnderTest = $this->createSUT();

        $mockHttpKernel = $this->createMock(HttpKernelInterface::class);
        $testRequest = new Request(
            [],
            $providedInput['request'],
            [],
            [],
            [],
            [],
            $providedInput['content']
        );
        
        $event = new RequestEvent(
            $mockHttpKernel,
            $testRequest,
            null
        );

        // act
        $output = $systemUnderTest->onKernelRequest($event);

        // assert
        self::assertSame(
            $event,
            $output
        );
        self::assertSame(
            $providedOutput,
            $output
                ->getRequest()
                ->request
                ->all()
        );
    }

    /**
     * createSUT
     *
     * @return \Jalismrs\Symfony\Bundle\JalismrsApiMiddlewareBundle\ConvertJsonRequestMiddleware
     */
    private function createSUT() : ConvertJsonRequestMiddleware
    {
        return new ConvertJsonRequestMiddleware(
            $this->testLogger
        );
    }
    
    /**
     * setUp
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->testLogger = new TestLogger();
    }
}
