<?php
if (!$results) {
    ?>
    <div class="span12" style="margin-left: 0">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-file-alt"></i>
                </span>
                <h5>Propostas</h5>
            </div>

            <div class="widget-content nopadding tab-content">
                <table id="tabela" class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Responsável</th>
                            <th>Data</th>
                            <th>Validade</th>
                            <th>Valor Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7">Nenhuma Proposta Encontrada</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
} else { ?>

    <div class="span12" style="margin-left: 0">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-file-alt"></i>
                </span>
                <h5>Propostas</h5>
            </div>

            <div class="widget-content nopadding tab-content">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Responsável</th>
                            <th>Data</th>
                            <th>Validade</th>
                            <th>Valor Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $r) {
                            $dataProposta = date(('d/m/Y'), strtotime($r->data_proposta));
                            $dataValidade = $r->data_validade ? date(('d/m/Y'), strtotime($r->data_validade)) : '-';
                            
                            switch ($r->status) {
                                case 'Aprovada':
                                case 'Concluído':
                                    $cor = '#256';
                                    break;
                                case 'Em aberto':
                                    $cor = '#17a2b8';
                                    break;
                                case 'Pendente':
                                    $cor = '#ffc107';
                                    break;
                                case 'Não aprovada':
                                    $cor = '#dc3545';
                                    break;
                                default:
                                    $cor = '#6c757d';
                                    break;
                            }

                            echo '<tr>';
                            echo '<td>' . ($r->numero_proposta ?: $r->idProposta) . '</td>';
                            echo '<td>' . $r->nome . '</td>';
                            echo '<td>' . $dataProposta . '</td>';
                            echo '<td>' . $dataValidade . '</td>';
                            echo '<td>R$ ' . number_format($r->valor_total, 2, ',', '.') . '</td>';
                            echo '<td><span class="badge" style="background-color: ' . $cor . '; border-color: ' . $cor . '">' . $r->status . '</span> </td>';

                            echo '<td>
                                <a href="' . base_url() . 'index.php/mine/visualizarProposta/' . $r->idProposta . '" class="btn-nwe" title="Visualizar"><i class="bx bx-show-alt"></i></a>
                                <a href="' . base_url() . 'index.php/mine/imprimirProposta/' . $r->idProposta . '" class="btn-nwe3" title="Imprimir" target="_blank"><i class="bx bx-printer"></i></a>
                            </td>';
                            echo '</tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php echo $this->pagination->create_links();
} ?>
