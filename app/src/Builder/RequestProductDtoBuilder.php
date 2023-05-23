<?php

namespace App\Builder;

use App\Dto\ProductDto2;

class RequestProductDtoBuilder
{
    private string $id;
    private string $sku;
    private string $label;
    private string $media_image_principale_1;
    private string $media_image_principale_1_s;
    private string $media_image_principale_1_m;
    private string $media_image_principale_1_l;
    private string $media_image_principale_2;
    private string $media_image_principale_2_s;
    private string $media_image_principale_2_m;
    private string $media_image_principale_2_l;
    private string $media_image_principale_3;
    private string $media_image_principale_3_s;
    private string $media_image_principale_3_m;
    private string $media_image_principale_3_l;
    private array $variants;


    public function __construct(array $array)
    {
        $this->setId($array)
            ->setSku($array)
            ->setLabel($array)
            ->setMediaImagePrincipale1($array)
            ->setMediaImagePrincipale1S($array)
            ->setMediaImagePrincipale1M($array)
            ->setMediaImagePrincipale1L($array)
            ->setMediaImagePrincipale2($array)
            ->setMediaImagePrincipale2S($array)
            ->setMediaImagePrincipale2M($array)
            ->setMediaImagePrincipale2L($array)
            ->setMediaImagePrincipale3($array)
            ->setMediaImagePrincipale3S($array)
            ->setMediaImagePrincipale3M($array)
            ->setMediaImagePrincipale3L($array)
            ->setVariants($array);
    }



    private function setId(array $array): RequestProductDtoBuilder
    {
        $this->id = $array['id'] ?? null;
        return $this;
    }

    private function setSku(array $array): RequestProductDtoBuilder
    {
        $this->sku = $array["sku"];
        return $this;
    }

    private function setLabel(array $array): RequestProductDtoBuilder
    {
        $this->label = $array['label'];
        return $this;
    }

    private function setMediaImagePrincipale1(array $array): RequestProductDtoBuilder
    {
        $attributeCode = 'media_image_principale_1';
        $url = '';

        array_walk_recursive($array, function ($value, $key) use ($attributeCode, &$url) {
            if ($key === 'code' && $value === $attributeCode) {
                $url = $value;
            }
        });

        $this->media_image_principale_1 = $url;
        return $this;
    }


    private function setMediaImagePrincipale1S(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_s = $this->extractUrlFromAttribute($array, 's');
        return $this;
    }

    private function setMediaImagePrincipale1M(array $array): RequestProductDtoBuilder
    {
        $attributeCode = 'media_image_principale_1';
        $url = '';

        foreach ($array['attributeGroups'] as $attributeGroup)
            if (isset($attributeGroup['attributes']))
                foreach ($attributeGroup['attributes'] as $attribute) {
                    if ($attribute['code'] === $attributeCode && isset($attribute['value']['urls']['s'])) {
                        $url = $attribute['value']['urls']['m'];
                        break 2; // Sortir des deux boucles
                    }
                }
        $this->media_image_principale_1_m = $this->extractUrlFromAttribute($array, 'm');
        return $this;
    }

    private function setMediaImagePrincipale1L(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_l = $this->extractUrlFromAttribute($array, 'l');
        return $this;
    }

    private function setMediaImagePrincipale2(array $array): RequestProductDtoBuilder
    {
        $attributeCode = 'media_image_principale_2';
        $url = '';

        array_walk_recursive($array, function ($value, $key) use ($attributeCode, &$url) {
            if ($key === 'code' && $value === $attributeCode) {
                $url = $value;
            }
        });

        $this->media_image_principale_1 = $url;
        return $this;
    }


    private function setMediaImagePrincipale2S(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_s = $this->extractUrlFromAttribute($array, 's');
        return $this;
    }

    private function setMediaImagePrincipale2M(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_m = $this->extractUrlFromAttribute($array, 'm');
        return $this;
    }

    private function setMediaImagePrincipale2L(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_l = $this->extractUrlFromAttribute($array, 'l');
        return $this;
    }


    private function setMediaImagePrincipale3(array $array): RequestProductDtoBuilder
    {
        $attributeCode = 'media_image_principale_3';
        $url = '';

        array_walk_recursive($array, function ($value, $key) use ($attributeCode, &$url) {
            if ($key === 'code' && $value === $attributeCode) {
                $url = $value;
            }
        });

        $this->media_image_principale_1 = $url;
        return $this;
    }


    private function setMediaImagePrincipale3S(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_s = $this->extractUrlFromAttribute($array, 's');
        return $this;
    }

    private function setMediaImagePrincipale3M(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_m = $this->extractUrlFromAttribute($array, 'm');
        return $this;
    }

    private function setMediaImagePrincipale3L(array $array): RequestProductDtoBuilder
    {
        $this->media_image_principale_1_l = $this->extractUrlFromAttribute($array, 'l');
        return $this;
    }
    private function extractUrlFromAttribute(array $array, string $urlKey): string
    {
        $attributeCode = 'media_image_principale_1';

        foreach ($array['attributeGroups'] as $attributeGroup)
            if (isset($attributeGroup['attributes']))
                foreach ($attributeGroup['attributes'] as $attribute) {
                    if ($attribute['code'] === $attributeCode && isset($attribute['value']['urls'][$urlKey])) {
                        return $attribute['value']['urls'][$urlKey];
                    }
                }

        return '';
    }

    private function setVariants(array $array): RequestProductDtoBuilder
    {
        $this->variants = [];

        if (isset($array['variants']) && is_array($array['variants'])) {
            foreach ($array['variants'] as $variantData) {
                $variant = [];

                $variant['id'] = $variantData['id'] ?? null;
                $variant['sku'] = $variantData['sku'] ?? null;
                $variant['label'] = $variantData['label'] ?? null;

                $variantImages = [];

                if (isset($variantData['attributes']) && is_array($variantData['attributes']))
                    foreach ($variantData['attributes'] as $attribute) {
                        if ($attribute['code'] === 'media_image_1') {
                            $variantImages['s'] = $attribute['value']['urls']['s'] ?? null;
                            $variantImages['m'] = $attribute['value']['urls']['m'] ?? null;
                            $variantImages['l'] = $attribute['value']['urls']['l'] ?? null;
                            break;
                        }
                    }

                $variant['images'] = $variantImages;

                $this->variants[] = $variant;
            }
        }

        return $this;
    }

    public function build(): RequestProductDto
    {
        return new RequestProductDto(

            id: $this->id,

            sku: $this->sku,

            label: $this->label,

            media_image_principale_1: $this->media_image_principale_1,

            media_image_principale_1_s: $this->media_image_principale_1_s,

            media_image_principale_1_m: $this->media_image_principale_1_m,

            media_image_principale_1_l: $this->media_image_principale_1_l,

            media_image_principale_2: $this->media_image_principale_2,

            media_image_principale_2_s: $this->media_image_principale_2_s,

            media_image_principale_2_m: $this->media_image_principale_2_m,

            media_image_principale_2_l: $this->media_image_principale_2_l,

            media_image_principale_3: $this->media_image_principale_3,

            media_image_principale_3_s: $this->media_image_principale_3_s,

            media_image_principale_3_m: $this->media_image_principale_3_m,

            media_image_principale_3_l: $this->media_image_principale_3_l,

            variants: $this->variants

        );
    }
}
