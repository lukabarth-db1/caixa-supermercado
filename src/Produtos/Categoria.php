<?php

declare(strict_types=1);

namespace App\Produtos;

class Categoria {
    private string $nome;

    public function __construct(string $nome) {
        $this->nome = $nome;
    }

    public function getNome(): string {
        return $this->nome;
    }
}
