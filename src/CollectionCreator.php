<?php

namespace App;

class CollectionCreator
{
    public function create(string $expand): CollectionExpand
    {
        $expands = explode(',', $expand);

        foreach ($expands as $expand) {

            $arr = [];
            foreach (explode('.', $expand) as $key => $item) {

                $arr[] = $item;
            }
        }

        $arr = [];
        foreach ($expands as $item) {
            $nested_array = [];
            $temp = &$nested_array;

            foreach (explode('.', $item) as $key => $value) {
                $temp = &$temp[$value];
            }
            $arr = array_merge_recursive($arr, $nested_array);
        }

        return $this->buildRecursiveCollection($arr, new CollectionExpand('transaction'));
    }

    protected function buildRecursiveCollection(array $expandNames, CollectionExpand &$collectionExpand): CollectionExpand
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

//        $expandChild->add(new CollectionExpand($key));
        }
        return $collectionExpand;
    }
}
