<?php

declare(strict_types=1);

namespace App\Produtos;

interface Perecivel {
    public function getDataValidade(): string;
}
