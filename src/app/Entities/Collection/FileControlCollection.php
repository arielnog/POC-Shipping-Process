<?php

namespace App\Entities\Collection;

use App\Entities\FileControl;
use App\Factories\FileControlFactory;
use Illuminate\Support\Collection;

class FileControlCollection extends Collection
{
    protected $items = [];

    public function __construct(FileControl ...$fileControl)
    {
        parent::__construct($fileControl);
    }

    public function addFile(FileControl $fileControl): self
    {
        $this->items[] = $fileControl;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public static function fromArray(array $fileControlArray): self
    {
        $clientsEntities = [];

        foreach ($fileControlArray as $fileControl) {
            $clientsEntities[] = FileControlFactory::fromArray($fileControl);
        }

        return new self(...$clientsEntities);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPathNames()
    {
        $arrPath = [];
        foreach ($this->items as $item) {
            $arrPath[] = $item->getPathName();
        }

        return $arrPath;
    }
}
