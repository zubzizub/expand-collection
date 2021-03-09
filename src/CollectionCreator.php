<?php

namespace App;

class CollectionCreator
{
    private string $expand;

    public function __construct(string $expand)
    {
        $this->expand = $expand;
    }

    public function create(): CollectionExpand
    {
        $expands = explode(',', $this->expand);

        $mergedExpand = [];
        foreach ($expands as $item) {
            $nested_array = [];
            $temp = &$nested_array;

            foreach (explode('.', $item) as $key => $value) {
                $temp = &$temp[$value];
            }
            $mergedExpand = array_replace_recursive($nested_array, $mergedExpand);
        }

        $collectionExpand = new CollectionExpand($this->expand);
        return $this->buildRecursiveCollection($mergedExpand, $collectionExpand);
    }

    protected function buildRecursiveCollection(array $expandNames, CollectionExpand $collectionExpand): CollectionExpand
    {
        if (empty($expandNames)) {
            return $collectionExpand;
        }

        foreach ($expandNames as $key => $item) {

            $collectionExpand->add(new CollectionExpand($key));

            if (is_array($item)) {
                $expandChild = $collectionExpand->getByName($key);
                $collectionExpand->expands[$key] = $this->buildRecursiveCollection($item, $expandChild);
            }
        }
        return $collectionExpand;
    }
}
