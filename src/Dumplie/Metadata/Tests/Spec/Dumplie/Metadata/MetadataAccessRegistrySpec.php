<?php

namespace Spec\Dumplie\Metadata;

use Dumplie\Metadata\Hydrator;
use Dumplie\Metadata\MetadataAccessObject;
use Dumplie\Metadata\Schema\Field\TextField;
use Dumplie\Metadata\Schema\TypeSchema;
use Dumplie\Metadata\Schema;
use Dumplie\Metadata\Storage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MetadataAccessRegistrySpec extends ObjectBehavior
{
    function let(Storage $storage, Hydrator $hydrator)
    {
        $builder = new Schema\Builder('schema');
        $builder->addType(new TypeSchema("product", ["sku" => new TextField()]));

        $this->beConstructedWith($storage, $builder, $hydrator);
    }

    function it_returns_MAO_for_existing_type_schema()
    {
        $this->getMAO("product")->shouldReturnAnInstanceOf(MetadataAccessObject::class);
    }
}

