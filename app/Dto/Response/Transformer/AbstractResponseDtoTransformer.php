<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

abstract class AbstractResponseDtoTransformer implements IResponseDtoTransformerInterface
{
    public function transformFromArrayItems(iterable $items): array
    {
        $dto = [];

        foreach ($items as $item) {
            $dto[] = $this->transformFromItem($item);
        }

        return $dto;
    }
}