<?php
namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;
use Codeception\Module\REST;
use Codeception\Module\Symfony;
use Codeception\TestInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\DependencyInjection\Container;

class Api extends \Codeception\Module
{
    /**
     * @var array
     */
    protected $mapUserToToken = [];

    /**
     * @var Symfony|null $symfony
     */
    private $symfony;

    public function _before(TestInterface $test)
    {
        /** @var REST $rest */
        $rest = $this->getModule('REST');
        $rest->haveHttpHeader('Accept', 'application/json');
    }

    /**
     * @throws ModuleException
     */
    public function amBearerAuthenticatedAsSpecifiedUser(string $username)
    {
        if (!array_key_exists($username, $this->mapUserToToken)) {
            $symfony = $this->getSymfony();
            $this->mapUserToToken[$username] = $symfony->grabService('lexik_jwt_authentication.encoder')->encode([
                'iat' => time(),
                'exp' => time() + 3600,
                'username' => $username,
            ]);
        }

        $rest = $this->getModule('REST');
        $rest->amBearerAuthenticated($this->mapUserToToken[$username]);
    }

    /**
     * Replace service by mock.
     * If you get `service is private, you cannot replace it` error, create a public alias in services_test.yaml
     *
     * @param string $serviceName
     * @param MockObject $mock
     * @throws ModuleException
     */
    public function mockService(string $serviceName, MockObject $mock)
    {
        $this->getSymfony()->kernel->getContainer()->set($serviceName, $mock);
    }

    /**
     * @throws ModuleException
     */
    private function getSymfony(): Symfony
    {
        if (null === $this->symfony) {
            $this->symfony = $this->getModule('Symfony');
        }

        return $this->symfony;
    }

    public function getSymfonyService(string $name)
    {
        return $this->getSymfony()->grabService($name);
    }

    public function getParameter(string $name)
    {
        /** @var Container $container */
        $container = $this->getSymfonyService('kernel')->getContainer();

        return $container->getParameter($name);
    }
}
