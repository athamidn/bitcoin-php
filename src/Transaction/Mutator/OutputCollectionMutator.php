<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Transaction\Mutator;

use BitWasp\Bitcoin\Transaction\TransactionOutputInterface;

class OutputCollectionMutator extends AbstractCollectionMutator
{
    /**
     * @param TransactionOutputInterface[] $outputs
     */
    public function __construct(array $outputs)
    {
        /** @var OutputMutator[] $set */
//        $this->set = new \SplFixedArray(count($outputs));
        $set = [];
        foreach ($outputs as $i => $output) {
            /** @var int $i */
//            $this->set[$i] = new OutputMutator($output);
            $set[$i] = new OutputMutator($output);
        }
    }


    /**
     * @return OutputMutator
     */
    public function current(): OutputMutator
    {
//        return $this->set->current();
        return parent::current();
    }

    /**
     * @param int $offset
     * @return OutputMutator
     */
    public function offsetGet($offset): OutputMutator
    {
//        if (!$this->set->offsetExists($offset)) {
//            throw new \OutOfRangeException('Nothing found at this offset');
//        }

        return parent::offsetGet($offset);

//        return $this->set->offsetGet($offset);
    }

    /**
     * @return TransactionOutputInterface[]
     */
    public function done(): array
    {
        $set = [];
        foreach ($this->set as $mutator) {
            $set[] = $mutator->done();
        }

        return $set;
    }

    /**
     * @param int $start
     * @param int $length
     * @return $this
     */
//    public function slice(int $start, int $length)
         public function slice(int $start, int $length): OutputCollectionMutator
    {
        $end = count($this->set);
        if ($start > $end || $length > $end) {
            throw new \RuntimeException('Invalid start or length');
        }
//
//        $this->set = \SplFixedArray::fromArray(array_slice($this->set->toArray(), $start, $length), false);

        $this->set = array_slice($this->set, $start, $length);

        return $this;
    }

    /**
     * @return $this
     */
//    public function null()
    public function null(): OutputCollectionMutator
{
        $this->slice(0, 0);
        return $this;
    }

    /**
     * @param TransactionOutputInterface $output
     * @return $this
     */
//    public function add(TransactionOutputInterface $output)
         public function add(TransactionOutputInterface $output): OutputCollectionMutator
    {
//        $size = $this->set->getSize();
//        $this->set->setSize($size + 1);

             $size = $this->count();

        $this->set[$size] = new OutputMutator($output);
        return $this;
    }

    /**
     * @param int $i
     * @param TransactionOutputInterface $output
     * @return $this
     */
//    public function set($i, TransactionOutputInterface $output)
          public function set(int $i, TransactionOutputInterface $output): OutputCollectionMutator
    {
        if ($i > count($this->set)) {
            throw new \InvalidArgumentException();
        }
        
        $this->set[$i] = new OutputMutator($output);
        return $this;
    }
}
