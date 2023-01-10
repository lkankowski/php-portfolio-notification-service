<?php


namespace App\Tests\acceptance\Eshop;

use App\Tests\AcceptanceTester;

class ProductCommandEndpointCest
{
    public function _before(AcceptanceTester $I): void
    {
    }

    public function addProduct(AcceptanceTester $I): void
    {
        $I->sendPost('/products');

        $I->seeResponseCodeIs(201); // created
        $I->dontSee();
    }

    public function removeProduct(AcceptanceTester $I): void
    {
        $I->sendPost('/products');

        $I->seeResponseCodeIs(204); // no content
        $I->seeResponseIsJson();
    }

    public function updateProduct(AcceptanceTester $I): void
    {
        $I->sendPost('/products');

        $I->seeResponseCodeIs(204); // no content
        $I->seeResponseIsJson();
    }
}
