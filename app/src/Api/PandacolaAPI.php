<?

namespace App\Api;

use App\Dto\CatalogueRequestDto;

class PandacolaAPI implements PandacolaApiInterface
{

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function getProducts(int $page = 1, int $size = 100): array
    {
        $data = new CatalogueRequestDto();
        $data->categories = [
            "code" => ["produits_actifs"]
        ];
        $data->page = $page;
        $data->size = $size;
        $data->filters = [
            "oaf-state-code" => ["value" => "11"]
        ];
        $data->sorts = [
            ["key" => "r-id",            "order" => "desc"]
        ];
        $data->addAttributeGroupsAttributesMarque();
        $data->addAttributeGroupsAttributesMediaImagePrincipale1();
        $data->addAttributeGroupsCode();
        $data->addId();
        $data->addLabel();
        $data->addSku();
        $data->addSlug();
        $data->addVariantsAttributesCouleurProduit();
        $data->addVariantsOffers();
        $data->addVariantsOffersAdditionalFieldsStateCode();
        $data->addVariantsOffersAdditionalFieldsVats();
        $data->language = 'fr-FR';
        $data->removeAttributeGroupsAttributesUrlsL();
        $data->removeAttributeGroupsAttributesUrlsS();
        $data->removeOffersBasePriceMinShippingPrice();
        $data->removeOffersBasePriceMinShippingPriceInfo();
        $data->removeVariantsOffersAllowQuotation();
        $data->removeVariantsOffersDescription();
        $data->removeVariantsOffersId();
        $data->removeVariantsOffersLeadTimeToShip();
        $data->removeVariantsOffersMinOrderQuantity();
        $data->removeVariantsOffersMinShippingPrice();
        $data->removeVariantsOffersMinShippingPriceInfo();
        $data->removeVariantsOffersShop();
        $data->removeVariantsOffersTaxes();

        $response = $this->client->request('POST', 'https://www.pandacola.com/api/trim/list/fr-FR/FR/categories', [
            'json' => $data,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $content = json_decode($response->getContent(), true);
        return [
            'items' => $content['items'],
            'total' => $content['total']
        ];
    }

    public function getProductBySku(string $sku): ?array
    {
        $response = $this->client->request('GET', "https://www.pandacola.com/api/catalogue/live/api/rest/v1/fr-FR/FR/channel/by-code/categories/products/by-sku/{$sku}", [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        return ($response->getStatusCode() === Response::HTTP_OK) ? json_decode($response->getContent(), true) : null;
    }
}
