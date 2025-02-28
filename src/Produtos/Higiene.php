<?php

declare(strict_types=1);

namespace App\Produtos;

class Higiene extends Produtos {
    private string $fragancia;
    private float $pesoVolume;

    public function __construct(
        int $codigo, string $nome, float $precoUnitario, string $unidadeMedida, Categoria $categoria, string $fragancia, float $pesoVolume
    ) {
        parent::__construct($codigo, $nome, $precoUnitario, $unidadeMedida, $categoria);
        $this->fragancia = $fragancia;
        $this->pesoVolume = $pesoVolume;
    }

    public function exibirDetalhes(): void {
        echo $this->detalhesProduto();
        echo "Fragância: $this->fragancia" . PHP_EOL;
        echo "Peso/volume: $this->pesoVolume" . PHP_EOL;
        echo str_repeat("-", 30) . PHP_EOL;
    }
}
