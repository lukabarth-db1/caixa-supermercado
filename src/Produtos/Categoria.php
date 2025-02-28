<?php

declare(strict_types=1);

namespace App\Produtos;

class Categoria {
    private string $nome;
    private string $descricao;

    public function __construct(string $nome, string $descricao) {
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }
}
