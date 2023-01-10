<?php


namespace App\Tests\acceptance\Eshop;

use App\Eshop\Domain\Entity\Product;
use App\Eshop\Infrastructure\DataFixtures\ProductFixture;
use App\Tests\AcceptanceTester;

class ProductQueryEndpointCest
{
    public function _before(AcceptanceTester $I): void
    {
    }

    public function getPaginatedList(AcceptanceTester $I): void
    {
        $I->loadFixtures(ProductFixture::class);

        $result = $I->sendGet('/products');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeHttpHeader('Content-type', 'application/json');
        $I->seeResponseJsonMatchesJsonPath('$.data');
        $I->assertCount(3, $I->grabDataFromResponseByJsonPath('$.data.*'));
        $I->seeResponseJsonMatchesJsonPath('$.data.[*].id');
        $I->seeResponseJsonMatchesJsonPath('$.data.[*].title');
        $I->seeResponseJsonMatchesJsonPath('$.data.[*].price');
        $I->seeResponseJsonMatchesJsonPath('$.data.[*].currency');
        $I->seeResponseJsonMatchesJsonPath('$.pager.first');
        $I->seeResponseJsonMatchesJsonPath('$.pager.last');
        $I->seeResponseJsonMatchesJsonPath('$.pager.previous');
        $I->seeResponseJsonMatchesJsonPath('$.pager.next');
    }

    public function getDetails(AcceptanceTester $I): void
    {
        $I->sendGet('/products/1');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
        $I->seeResponseJsonMatchesJsonPath('$.data.title');
        $I->seeResponseJsonMatchesJsonPath('$.data.price');
        $I->seeResponseJsonMatchesJsonPath('$.data.currency');
    }
}
