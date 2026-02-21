<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="fas fa-file-alt"></i>
        </span>
        <h5>Proposta Comercial #<?php echo $result->numero_proposta ?: $result->idProposta; ?></h5>
        <div class="buttons">
            <a target="_blank" title="Imprimir" class="btn btn-mini btn-inverse" href="<?php echo base_url() ?>index.php/mine/imprimirProposta/<?php echo $result->idProposta; ?>"><i class="fas fa-print"></i> Imprimir</a>
        </div>
    </div>
    <div class="widget-content">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="span4">
                    <img src="<?php echo $emitente->url_logo; ?>" style="max-height: 100px">
                </div>
                <div class="span4" style="text-align: center">
                    <h3><?php echo $emitente->nome; ?></h3>
                    <span><?php echo $emitente->rua . ', ' . $emitente->numero . ' - ' . $emitente->bairro; ?></span><br />
                    <span><?php echo $emitente->cidade . ' - ' . (isset($emitente->uf) ? $emitente->uf : (isset($emitente->estado) ? $emitente->estado : '')) . ' - CEP: ' . $emitente->cep; ?></span><br />
                    <span><?php echo $emitente->email . ' - ' . $emitente->telefone; ?></span>
                </div>
                <div class="span4" style="text-align: right">
                    <span>Proposta: <?php echo $result->numero_proposta ?: $result->idProposta; ?></span><br />
                    <span>Data: <?php echo date('d/m/Y', strtotime($result->data_proposta)); ?></span><br />
                    <?php if ($result->data_validade) { ?>
                        <span>Validade: <?php echo date('d/m/Y', strtotime($result->data_validade)); ?></span><br />
                    <?php } ?>
                    <span>Status: <span class="badge" style="background-color: <?php 
                        switch ($result->status) {
                            case 'Aprovada': case 'Concluído': echo '#256'; break;
                            case 'Em aberto': echo '#17a2b8'; break;
                            case 'Pendente': echo '#ffc107'; break;
                            case 'Não aprovada': echo '#dc3545'; break;
                            default: echo '#6c757d'; break;
                        }
                    ?>"><?php echo $result->status; ?></span></span>
                </div>
            </div>
        </div>

        <hr />

        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="span6">
                    <h5>Cliente</h5>
                    <span><strong><?php echo $result->nomeCliente; ?></strong></span><br />
                    <span><?php echo $result->rua . ', ' . $result->numero . ' - ' . $result->bairro; ?></span><br />
                    <span><?php echo $result->cidade . ' - ' . (isset($result->estado) ? $result->estado : (isset($result->uf) ? $result->uf : '')) . ' - CEP: ' . $result->cep; ?></span><br />
                    <span>Email: <?php echo $result->email; ?></span><br />
                    <span>Celular: <?php echo $result->celular_cliente; ?></span>
                </div>
                <div class="span6">
                    <h5>Vendedor</h5>
                    <span><strong><?php echo $result->nome; ?></strong></span><br />
                    <span>Telefone: <?php echo $result->telefone_usuario; ?></span><br />
                    <span>Email: <?php echo $result->email_usuario; ?></span>
                </div>
            </div>
        </div>

        <hr />

        <?php if ($produtos) { ?>
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <h5>Produtos</h5>
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th width="10%">Qtd</th>
                                <th width="15%">Preço Unit.</th>
                                <th width="15%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalProdutos = 0;
                            foreach ($produtos as $p) {
                                $subtotal = $p->quantidade * $p->preco;
                                $totalProdutos += $subtotal;
                                echo '<tr>';
                                echo '<td>' . $p->descricao . '</td>';
                                echo '<td>' . number_format($p->quantidade, 2, ',', '.') . '</td>';
                                echo '<td>R$ ' . number_format($p->preco, 2, ',', '.') . '</td>';
                                echo '<td>R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                                echo '</tr>';
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right"><strong>Total Produtos:</strong></td>
                                <td><strong>R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php } ?>

        <?php if ($servicos) { ?>
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <h5>Serviços</h5>
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Serviço</th>
                                <th width="10%">Qtd</th>
                                <th width="15%">Preço Unit.</th>
                                <th width="15%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalServicos = 0;
                            foreach ($servicos as $s) {
                                $subtotal = $s->quantidade * $s->preco;
                                $totalServicos += $subtotal;
                                echo '<tr>';
                                echo '<td>' . $s->descricao . '</td>';
                                echo '<td>' . number_format($s->quantidade, 2, ',', '.') . '</td>';
                                echo '<td>R$ ' . number_format($s->preco, 2, ',', '.') . '</td>';
                                echo '<td>R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                                echo '</tr>';
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right"><strong>Total Serviços:</strong></td>
                                <td><strong>R$ <?php echo number_format($totalServicos, 2, ',', '.'); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php } ?>

        <?php if ($outros) { ?>
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <h5>Outros</h5>
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th width="15%">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalOutros = 0;
                            foreach ($outros as $o) {
                                $totalOutros += $o->preco;
                                echo '<tr>';
                                echo '<td>' . nl2br($o->descricao) . '</td>';
                                echo '<td>R$ ' . number_format($o->preco, 2, ',', '.') . '</td>';
                                echo '</tr>';
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right"><strong>Total Outros:</strong></td>
                                <td><strong>R$ <?php echo number_format($totalOutros, 2, ',', '.'); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php } ?>

        <div class="row-fluid" style="margin-top:0">
            <div class="span12" style="text-align: right">
                <?php 
                $subtotal = ($totalProdutos ?? 0) + ($totalServicos ?? 0) + ($totalOutros ?? 0);
                $desconto = floatval($result->valor_desconto ?? 0);
                $total = $subtotal - $desconto;
                ?>
                <h4>Resumo</h4>
                <span>Subtotal: R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span><br />
                <?php if ($desconto > 0) { ?>
                    <span>Desconto: - R$ <?php echo number_format($desconto, 2, ',', '.'); ?></span><br />
                <?php } ?>
                <h3 style="margin-top: 10px">TOTAL: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>
            </div>
        </div>

        <?php if ($result->observacoes) { ?>
            <hr />
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <h5>Observações</h5>
                    <p><?php echo nl2br($result->observacoes); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
