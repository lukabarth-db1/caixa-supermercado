<?php

declare(strict_types=1);

namespace App\Produtos;

class Alimento extends Produtos implements Perecivel {
    private string $dataValidade;

    public function __construct(
        int $codigo, string $nome, float $precoUnitario, string $unidadeMedida, string $dataValidade
    ) {
        parent::__construct($codigo, $nome, $precoUnitario, $unidadeMedida);
        $this->dataValidade = $dataValidade;
    }
        
    public function getDataValidade(): string {
        return $this->dataValidade;
    }

    public function exibirDetalhes(): void {
        echo $this->detalhesProduto();
        echo "Validade: $this->dataValidade" . PHP_EOL;
        echo str_repeat("-", 30) . PHP_EOL;
    }
}
