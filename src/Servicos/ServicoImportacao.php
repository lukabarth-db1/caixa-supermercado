<?php

declare(strict_types=1);

namespace App\Servicos;

class ServicoImportacao {
    public function aplicarTaxa(array $produtos): void {
        foreach ($produtos as $produto) {
            if ($produto->getCategoria()->getNome() === "Importado") {
                $produto->aplicarTaxaSeImportado();
            }
        }
    }
}
