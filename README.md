## Requisitos Funcionais
 
**Produtos**: Cada produto tem um código, nome, preço unitário e categoria (exemplo: alimentos, bebidas, higiene).
 
**Carrinho de Compras**: O cliente pode adicionar produtos ao carrinho, remover produtos e visualizar os itens antes do pagamento.
 
**Pagamento**: O cliente pode pagar com dinheiro, PIX, cartão de crédito ou débito. O sistema deve calcular o troco quando necessário.
 
**Cupom Fiscal**: Após o pagamento, o sistema deve gerar um cupom fiscal contendo a lista de produtos comprados, o valor total e a forma de pagamento.
 
## Restrições
- O cliente não pode finalizar a compra com um carrinho vazio
- Pagamentos em PIX geram 5% de desconto para o cliente
 
## Bônus
- Desenvolver um Caixa Rápido. O Caixa Rápido só poderá processar no máximo 20 itens.
- Criar uma categoria chamada "internacional" e aplicar 10% de taxa em cima do valor do produto em caso de compra