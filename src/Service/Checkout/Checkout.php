<?php

namespace Service\Checkout;

use Service\Processor\CheckoutProcessor;
use Service\Builder\IBuilder;
use Service\Builder\CheckoutBuilder;
use Service\User\ISecurity;

class Checkout
{
    protected $builder;
    protected $processor;
    protected $products;
    protected $security;

    public function __construct(array $products, ISecurity $security)
    {
        $this->products = $products;
        $this->security = $security;
    }

    public function setBuilder(IBuilder $builder = null)
    {
        $this->builder = $builder ?: new CheckoutBuilder();
        $this->builder->setProducts($this->products);

        // By default `new Card()`
        $this->builder->setBilling();

        // by default `new NullObject()`
        $this->builder->setDiscounting();

        // by default `new Email()`
        $this->builder->setCommunication();

        $this->builder->setUsersSecurity($this->security);
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    public function setProcessor(IProcessor $processor = null)
    {
        $this->processor = $processor ?: new CheckoutProcessor($this->getBuilder());
    }

    public function getProcessor()
    {
        return $this->processor;
    }

    public function makeCheckout()
    {
        $this->setBuilder();
        $this->setProcessor();

        return $this->processor->process();
    }
}
