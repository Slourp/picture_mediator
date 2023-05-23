<?

namespace App\Builder;


class CatalogueRequestDto
{
    public  array $fields;

    public function __construct()
    {
        $this->fields = [
            'includes' => [],
            'excludes' => []
        ];
    }
}
