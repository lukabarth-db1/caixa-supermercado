<?php

declare(strict_types=1);

namespace App\Pagamentos;

use App\CarrinhoDeCompras\CarrinhoDeCompras;

class PagamentoInternacional extends Pagamento {
    public function __construct(CarrinhoDeCompras $carrinho, string $metodoPagamento) {
        parent::__construct($carrinho, $metodoPagamento);
    }

    public function processarPagamento(): void {
        $this->valorTotal *= 1.10;

        parent::processarPagamento();
    }
}