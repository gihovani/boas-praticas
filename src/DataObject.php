<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class DataObject
{
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}