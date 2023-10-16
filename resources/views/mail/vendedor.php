<?php
$lista_vendas = '';
$total_vendas = 0;
$total_comissao = 0;
foreach ($vendas as $venda) {
    $total_vendas += $venda['valor'];
    $total_comissao += $venda['comissao'];

    $lista_vendas .= '<tr>' .
    '<td>' . $venda['id'] . '</td>' .
    '<td>' . number_format($venda['valor'], 2, ',', '.') . '</td>' .
    '<td>' . number_format($venda['comissao'], 2, ',', '.') . '</td>' .
        '</tr>';
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Relatório diário de Comissão</h2>
<p>Olá <?php echo $vendedor; ?>, este é seu relatório de vendas do dia <?php echo date('d/m/Y') ?>.</p>
<p>A sua comissão foi de <?php echo number_format($total_comissao, 2, ',', '.'); ?> R$.</p>
<table>
    <tr>
        <th>ID Venda</th>
        <th>Valor</th>
        <th>Comissão</th>
    </tr>
    <?php echo $lista_vendas; ?>
    <tr>
        <th>Total</th>
        <th><?php echo number_format($total_vendas, 2, ',', '.'); ?> R$</th>
        <th><?php echo number_format($total_comissao, 2, ',', '.'); ?> R$</th>
    </tr>
</table>
</body>
</html>
