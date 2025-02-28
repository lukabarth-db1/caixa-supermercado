<?php

declare(strict_types=1);

namespace App\Caixa;

use App\Pagamentos\Pagamento;
use App\CarrinhoDeCompras\CarrinhoDeCompras;

class CaixaRapido extends Caixa {
    private int $limiteItens;

    public function __construct(int $numeroCaixa, int $limiteItens = 20) {
        parent::__construct($numeroCaixa);
        $this->limiteItens = $limiteItens;
    }

    public function processarCompra(Pagamento $pagamento): void {
        if (!$this->aberto) {
            echo "O caixa está fechado! Abra o caixa antes de processar pagamentos";
        }

        if (count($pagamento->getCarrinho()->getProdutos()) > $this->limiteItens) {
            echo "Não é permitido mais que $this->limiteItens itens no caixa rápido.";
            return;
        }
        parent::processarCompra($pagamento);
    }
}
