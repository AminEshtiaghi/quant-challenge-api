<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

interface IResponseDtoTransformerInterface
{
    public function transformFromItem($item);
    public function transformFromArrayItems(iterable $items): iterable;
}