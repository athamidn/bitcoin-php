<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Transaction\Mutator;

abstract class AbstractCollectionMutator implements \Iterator, \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    protected $set = [];

    private $position = 0;

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->set;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return count($this->set) === 0;

    }

    /**
     * @return int
     */
    public function count(): int
    {
//        return $this->set->count();
        return count($this->set);
    }

    /**
     *
     */
    public function rewind()
    {
//        throw new \InvalidArgumentException('=================== rewind =======================');

//        $this->set->rewind();
        $this->position = 0;
    }

    /**
     * @return mixed
     */
    public function current()
    {
//        throw new \InvalidArgumentException('=================== current =======================');

//        return $this->set->current();
        return $this->set[$this->position];
    }

    /**
     * @return int
     */
    public function key()
    {

//        throw new \InvalidArgumentException('=================== key =======================');


//        return $this->set->key();
        return $this->position;
    }

    /**
     *
     */
    public function next()
    {

//        throw new \InvalidArgumentException('=================== next =======================');


//        $this->set->next();
        ++$this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
//        throw new \InvalidArgumentException('=================== valid =======================');


//        return $this->set->valid();
        return array_key_exists($this->position, $this->set);
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
//        return $this->set->offsetExists($offset);
        return array_key_exists($offset, $this->set);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \InvalidArgumentException('Offset does not exist');
        }

//        $this->set->offsetUnset($offset);
        $this->set = array_slice($this->set, 0, $offset - 1) + array_slice($this->set, $offset + 1);
    }

    /**
     * @param int $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
//        if (!$this->set->offsetExists($offset)) {
            if (!array_key_exists($offset, $this->set)) {
            throw new \OutOfRangeException('Nothing found at this offset');
        }
//        return $this->set->offsetGet($offset);
        return $this->set[$offset];
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
//        $this->set->offsetSet($offset, $value);
        if ($offset > count($this->set)) {
            throw new \InvalidArgumentException();
        }
        $this->set[$offset] = $value;
    }
}