<?php

use App\CollectionExpand;
use PHPUnit\Framework\TestCase;

class ExpandCollectionTest extends TestCase
{
    public function testSuccess()
    {
        $collectionExpand = $this->createCollectionExpand();

        self::assertCount(2, $collectionExpand);
        self::assertTrue($collectionExpand->has('bonus'));

        $bonusExpand = $collectionExpand->getByName('bonus');

        self::assertInstanceOf(CollectionExpand::class, $bonusExpand);
        self::assertCount(2, $bonusExpand);
        self::assertTrue($bonusExpand->has('budget'));
        self::assertTrue($bonusExpand->has('accrual_rules'));

        $budgetExpand = $bonusExpand->getByName('budget');

        $currencyExpand = $budgetExpand->getByName('currency');
        self::assertInstanceOf(CollectionExpand::class, $currencyExpand);
        self::assertTrue($budgetExpand->has('currency'));
    }

    public function testCreateCollectionSuccess()
    {
        self::assertTrue(true);
    }

    private function createCollectionExpand(): CollectionExpand
    {
        $collectionExpand = new CollectionExpand('transaction');

        $currencyExpand = new CollectionExpand('currency');
        $budgetExpand = new CollectionExpand('budget');
        $accrualRulesExpand = new CollectionExpand('accrual_rules');
        $bonusExpand = new CollectionExpand('bonus');
        $playerExpand = new CollectionExpand('player');

        // Add budget, accrual_rules to Bonus
        $bonusExpand->add($budgetExpand);
        $bonusExpand->add($accrualRulesExpand);

        // Add currency to Budget
        $budgetExpand->add($currencyExpand);

        // Add bonus,player to Collection
        $collectionExpand->add($bonusExpand);
        $collectionExpand->add($playerExpand);

        return $collectionExpand;
    }
}
