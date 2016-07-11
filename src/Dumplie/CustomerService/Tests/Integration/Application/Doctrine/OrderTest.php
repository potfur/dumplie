<?php

declare (strict_types = 1);

namespace Dumplie\CustomerService\Tests\Integration\Application\Doctrine;

use Doctrine\ORM\EntityManager;
use Dumplie\SharedKernel\Infrastructure\InMemory\InMemoryEventLog;
use Dumplie\CustomerService\Tests\Doctrine\ORMCustomerServiceContext;
use Dumplie\CustomerService\Tests\Doctrine\ORMCustomerServiceMapping;
use Dumplie\CustomerService\Tests\Integration\Application\Generic\OrderTestCase;
use Dumplie\SharedKernel\Tests\Context\Tactician\TacticianFactory;
use Dumplie\SharedKernel\Tests\Doctrine\ORMHelper;

final class OrderTest extends OrderTestCase
{
    use ORMHelper;
    use ORMCustomerServiceMapping;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public static function setUpBeforeClass()
    {
        self::createDatabase();
    }

    function setUp()
    {
        $emBuilder = $this->entityManagerBuilder();
        $this->registerCustomerServiceMapping($emBuilder);

        $this->entityManager = $emBuilder->build();
        $this->createSchema($this->entityManager);

        $this->customerServiceContext = new ORMCustomerServiceContext($this->entityManager, new InMemoryEventLog(), new TacticianFactory());
    }

    public function tearDown()
    {
        $this->dropSchema($this->entityManager);
    }
}