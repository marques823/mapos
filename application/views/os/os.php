<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table-custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<style>
  select {
    width: 70px;
  }
  
  /* Esconder colunas em mobile - estilo inline para garantir */
  @media (max-width: 767px) {
    .table.table-bordered thead th:nth-child(1),
    .table.table-bordered thead th:nth-child(3),
    .table.table-bordered thead th:nth-child(4),
    .table.table-bordered thead th:nth-child(5),
    .table.table-bordered thead th:nth-child(6),
    .table.table-bordered thead th:nth-child(7),
    .table.table-bordered thead th:nth-child(8),
    .table.table-bordered thead th:nth-child(9),
    .table.table-bordered thead th:nth-child(10),
    .table.table-bordered tbody td:nth-child(1),
    .table.table-bordered tbody td:nth-child(3),
    .table.table-bordered tbody td:nth-child(4),
    .table.table-bordered tbody td:nth-child(5),
    .table.table-bordered tbody td:nth-child(6),
    .table.table-bordered tbody td:nth-child(7),
    .table.table-bordered tbody td:nth-child(8),
    .table.table-bordered tbody td:nth-child(9),
    .table.table-bordered tbody td:nth-child(10) {
      display: none !important;
    }
    
    /* Tabela dinâmica que se ajusta ao tamanho da tela */
    .table-responsive {
      width: 100% !important;
      overflow-x: auto !important;
      -webkit-overflow-scrolling: touch !important;
    }
    
    .table.table-bordered {
      width: 100% !important;
      table-layout: auto !important;
      min-width: 100% !important;
    }
    
    .table.table-bordered thead th:nth-child(2),
    .table.table-bordered tbody td:nth-child(2) {
      width: auto !important;
      min-width: 120px !important;
      max-width: 45% !important;
    }
    
    .table.table-bordered thead th:nth-child(11),
    .table.table-bordered tbody td:nth-child(11) {
      width: auto !important;
      min-width: 80px !important;
      max-width: 30% !important;
    }
    
    .table.table-bordered thead th:nth-child(12),
    .table.table-bordered tbody td:nth-child(12) {
      width: auto !important;
      min-width: 60px !important;
      max-width: 25% !important;
      text-align: center !important;
    }
    
    /* Ajustar padding das células em mobile */
    .table.table-bordered thead th,
    .table.table-bordered tbody td {
      padding: 8px 6px !important;
      font-size: 13px !important;
    }
    
    /* Esconder todos os botões exceto Visualizar na coluna Ações em mobile */
    .table.table-bordered tbody td:nth-child(12) .hide-mobile-col,
    .table.table-bordered tbody td:nth-child(12) span.hide-mobile-col,
    .table.table-bordered tbody td:nth-child(12) span.hide-mobile-col a,
    .table.table-bordered tbody td:nth-child(12) span.hide-mobile-col button {
      display: none !important;
    }
    
    /* Garantir que apenas o botão Visualizar apareça */
    .table.table-bordered tbody td:nth-child(12) .mobile-action-btn {
      display: inline-block !important;
      min-width: 44px !important;
      min-height: 44px !important;
    }
    
    /* Garantir que filtros fiquem escondidos por padrão em mobile */
    #formFiltros.hide-mobile-form {
      display: none !important;
    }
    
    /* Quando o filtro está visível (após toggle) */
    #formFiltros.hide-mobile-form[style*="display: block"],
    #formFiltros.hide-mobile-form[style*="display:block"] {
      display: block !important;
    }
    
    /* Esconder botões dentro de hide-mobile-col em mobile */
    .hide-mobile-col,
    td.hide-mobile-col,
    th.hide-mobile-col,
    span.hide-mobile-col {
      display: none !important;
    }
    
    /* Esconder todos os elementos dentro de hide-mobile-col */
    .hide-mobile-col a,
    .hide-mobile-col button,
    .hide-mobile-col span,
    td.hide-mobile-col a,
    td.hide-mobile-col button,
    td.hide-mobile-col span,
    span.hide-mobile-col a,
    span.hide-mobile-col button,
    span.hide-mobile-col span {
      display: none !important;
    }
  }
  
  /* Regras para desktop (fora do bloco mobile) */
  @media (min-width: 768px) {
    /* Mostrar filtros no desktop */
    #formFiltros.hide-mobile-form {
      display: block !important;
    }
    
    /* Mostrar colunas escondidas no desktop */
    .hide-mobile-col,
    td.hide-mobile-col,
    th.hide-mobile-col,
    span.hide-mobile-col {
      display: table-cell !important;
    }
    
    .hide-mobile-col a,
    .hide-mobile-col button,
    .hide-mobile-col span,
    td.hide-mobile-col a,
    td.hide-mobile-col button,
    td.hide-mobile-col span,
    span.hide-mobile-col a,
    span.hide-mobile-col button,
    span.hide-mobile-col span {
      display: inline-block !important;
    }
  }
  
  /* Regras gerais (aplicam-se em todos os tamanhos de tela) */
  /* Quebra de linha na coluna Cliente */
  .table.table-bordered tbody td.cli1 {
    word-wrap: break-word !important;
    word-break: break-word !important;
    white-space: normal !important;
    overflow-wrap: break-word !important;
  }
  
  .table.table-bordered tbody td.cli1 a {
    word-wrap: break-word !important;
    word-break: break-word !important;
    white-space: normal !important;
    overflow-wrap: break-word !important;
    display: inline-block !important;
    max-width: 100% !important;
    line-height: 1.4 !important;
  }
  
  /* Padronizar botões Nova OS e Filtros */
  .button-group-mobile {
    width: 100% !important;
    box-sizing: border-box !important;
    max-width: 100% !important;
  }
  
  .button-group-mobile .button,
  .button-group-mobile .btn,
  .button-group-mobile button,
  .button-group-mobile a {
    flex: 1 1 0 !important;
    min-width: 0 !important;
    height: 38px !important;
    min-height: 38px !important;
    max-height: 38px !important;
    padding: 8px 12px !important;
    font-size: 14px !important;
    border-radius: 4px !important;
    font-weight: 500 !important;
    box-sizing: border-box !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
  }
  
  .button-group-mobile .button__icon,
  .button-group-mobile .button__text2 {
    display: inline-flex !important;
    align-items: center !important;
    flex-shrink: 0 !important;
  }
  
  .button-group-mobile .button__text2 {
    margin-left: 4px !important;
  }
  
  /* Melhorar select de status */
  select.span12 {
    font-size: 16px !important;
    padding: 8px 12px !important;
    height: auto !important;
    min-height: 38px !important;
    -webkit-appearance: menulist !important;
    -moz-appearance: menulist !important;
    appearance: menulist !important;
  }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
            <span class="icon">
                <i class="fas fa-diagnoses"></i>
            </span>
            <h5>Ordens de Serviço</h5>
        </div>
    <div class="span12" style="margin-left: 0">
        <div class="span12" style="margin-bottom: 10px;">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')) { ?>
                <div class="hide-mobile">
                    <a href="<?php echo base_url(); ?>index.php/os/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Ordem de Serviço</span></a>
                </div>
                <div class="show-mobile button-group-mobile" style="display: flex; gap: 10px; margin-bottom: 10px; width: 100%; box-sizing: border-box;">
                    <a href="<?php echo base_url(); ?>index.php/os/adicionar" class="button btn btn-mini btn-success" style="flex: 1 1 0; min-width: 0; height: 38px; display: flex; align-items: center; justify-content: center; padding: 8px 12px; box-sizing: border-box;">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Nova OS</span></a>
                    <button type="button" class="button btn btn-mini btn-info" id="btnToggleFiltros" style="flex: 1 1 0; min-width: 0; height: 38px; display: flex; align-items: center; justify-content: center; padding: 8px 12px; box-sizing: border-box;">
                        <span class="button__icon"><i class='bx bx-filter'></i></span><span class="button__text2">Filtros</span>
                    </button>
                </div>
            <?php } else { ?>
                <div class="show-mobile" style="margin-bottom: 10px;">
                    <button type="button" class="button btn btn-mini btn-info" id="btnToggleFiltros" style="width: 100%; min-height: 44px; display: flex; align-items: center; justify-content: center;">
                        <span class="button__icon"><i class='bx bx-filter'></i></span><span class="button__text2">Filtros</span>
                    </button>
                </div>
            <?php } ?>
        </div>
        <form method="get" action="<?php echo base_url(); ?>index.php/os/gerenciar" id="formFiltros" class="hide-mobile-form">
            <div class="span12" style="margin-left: 0; margin-bottom: 10px;">
                <div class="span12" style="margin-left: 0;">
                    <input type="text" name="pesquisa" id="pesquisa" placeholder="Nome do cliente a pesquisar" class="span12" value="<?=set_value('pesquisa')?>" inputmode="text" style="font-size: 16px; padding: 8px 12px;">
                </div>
            </div>
            <div class="span12" style="margin-left: 0; margin-bottom: 10px;">
                <div class="span12" style="margin-left: 0;">
                    <select name="status" id="statusFiltro" class="span12" style="font-size: 16px; padding: 8px 12px; height: auto; min-height: 38px;">
                        <option value="">Selecione status</option>
                        <option value="Aberto" <?=$this->input->get('status') == 'Aberto' ? 'selected' : ''?>>Aberto</option>
                        <option value="Faturado" <?=$this->input->get('status') == 'Faturado' ? 'selected' : ''?>>Faturado</option>
                        <option value="Negociação" <?=$this->input->get('status') == 'Negociação' ? 'selected' : ''?>>Negociação</option>
                        <option value="Em Andamento" <?=$this->input->get('status') == 'Em Andamento' ? 'selected' : ''?>>Em Andamento</option>
                        <option value="Orçamento" <?=$this->input->get('status') == 'Orçamento' ? 'selected' : ''?>>Orçamento</option>
                        <option value="Finalizado" <?=$this->input->get('status') == 'Finalizado' ? 'selected' : ''?>>Finalizado</option>
                        <option value="Cancelado" <?=$this->input->get('status') == 'Cancelado' ? 'selected' : ''?>>Cancelado</option>
                        <option value="Aguardando Peças" <?=$this->input->get('status') == 'Aguardando Peças' ? 'selected' : ''?>>Aguardando Peças</option>
                        <option value="Aprovado" <?=$this->input->get('status') == 'Aprovado' ? 'selected' : ''?>>Aprovado</option>
                    </select>
                </div>
            </div>
            <div class="span12" style="margin-left: 0; margin-bottom: 10px;">
                <div class="span6" style="margin-left: 0;">
                    <label for="data" style="display: block; margin-bottom: 5px; font-weight: 500;">Data Inicial</label>
                    <input type="date" name="data_native" id="data" class="span12" value="<?php 
                        $dataGet = $this->input->get('data');
                        if ($dataGet) {
                            $parts = explode('/', $dataGet);
                            if (count($parts) == 3) {
                                $year = $parts[2];
                                if (strlen($year) == 2) {
                                    $year = '20' . $year;
                                }
                                echo $year . '-' . $parts[1] . '-' . $parts[0];
                            }
                        }
                    ?>" style="font-size: 16px; padding: 8px 12px;">
                </div>
                <div class="span6">
                    <label for="data2" style="display: block; margin-bottom: 5px; font-weight: 500;">Data Final</label>
                    <input type="date" name="data2_native" id="data2" class="span12" value="<?php 
                        $data2Get = $this->input->get('data2');
                        if ($data2Get) {
                            $parts = explode('/', $data2Get);
                            if (count($parts) == 3) {
                                $year = $parts[2];
                                if (strlen($year) == 2) {
                                    $year = '20' . $year;
                                }
                                echo $year . '-' . $parts[1] . '-' . $parts[0];
                            }
                        }
                    ?>" style="font-size: 16px; padding: 8px 12px;">
                </div>
            </div>
            <div class="span12" style="margin-left: 0;">
                <button type="submit" class="button btn btn-mini btn-warning" style="width: 100%; min-height: 44px;">
                    <span class="button__icon"><i class='bx bx-search-alt'></i></span><span class="button__text2">Buscar</span>
                </button>
            </div>
        </form>
    </div>

    <div class="widget-box" style="margin-top: 8px">
        <div class="widget-content nopadding">
            <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
                <table class="table table-bordered" style="width: 100%; table-layout: auto;">
                    <thead>
                        <tr>
                            <th class="hide-mobile-col">N°</th>
                            <th>Cliente</th>
                            <th class="ph1 hide-mobile-col">Responsável</th>
                            <th class="hide-mobile-col">Data Inicial</th>
                            <th class="ph2 hide-mobile-col">Data Final</th>
                            <th class="ph3 hide-mobile-col">Venc. Garantia</th>
                            <th class="hide-mobile-col">Valor Total</th>
                            <th class="hide-mobile-col">Desconto</th>
                            <th class="hide-mobile-col">Valor com Desconto</th>
                            <th class="ph4 hide-mobile-col">V.T (Faturado)</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$results) {
                            echo '<tr>
                            <td colspan="12">Nenhuma OS Cadastrada</td>
                            </tr>';
                        }

                        $this->load->model('os_model'); foreach ($results as $r) {
                                $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
                                if ($r->dataFinal != null) {
                                    $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
                                } else {
                                    $dataFinal = "";
                                }
                                if ($this->input->get('pesquisa') === null && is_array(json_decode($configuration['os_status_list']))) {
                                    if (in_array($r->status, json_decode($configuration['os_status_list'])) != true) {
                                        continue;
                                    }
                                }

                                switch ($r->status) {
                                    case 'Aberto':
                                        $cor = '#00cd00';
                                        break;
                                    case 'Em Andamento':
                                        $cor = '#436eee';
                                        break;
                                    case 'Orçamento':
                                        $cor = '#CDB380';
                                        break;
                                    case 'Negociação':
                                        $cor = '#AEB404';
                                        break;
                                    case 'Cancelado':
                                        $cor = '#CD0000';
                                        break;
                                    case 'Finalizado':
                                        $cor = '#256';
                                        break;
                                    case 'Faturado':
                                        $cor = '#B266FF';
                                        break;
                                    case 'Aguardando Peças':
                                        $cor = '#FF7F00';
                                        break;
                                    case 'Aprovado':
                                        $cor = '#808080';
                                        break;
                                    default:
                                        $cor = '#E0E4CC';
                                        break;
                                }
                                $vencGarantia = '';

                                if ($r->garantia && is_numeric($r->garantia)) {
                                    $vencGarantia = dateInterval($r->dataFinal, $r->garantia);
                                }
                                $corGarantia = '';
                                if (!empty($vencGarantia)) {
                                    $dataGarantia = explode('/', $vencGarantia);
                                    $dataGarantiaFormatada = $dataGarantia[2] . '-' . $dataGarantia[1] . '-' . $dataGarantia[0];
                                    if (strtotime($dataGarantiaFormatada) >= strtotime(date('d-m-Y'))) {
                                        $corGarantia = '#4d9c79';
                                    } else {
                                        $corGarantia = '#f24c6f';
                                    }
                                } elseif ($r->garantia == "0") {
                                    $vencGarantia = 'Sem Garantia';
                                    $corGarantia = '';
                                } else {
                                    $vencGarantia = '';
                                    $corGarantia = '';
                                }

                                echo '<tr>';
                                echo '<td class="hide-mobile-col">' . $r->idOs . '</td>';
                                echo '<td class="cli1"><a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '">' . $r->nomeCliente . '</a></td>';
                                echo '<td class="ph1 hide-mobile-col">' . $r->nome . '</td>';
                                echo '<td class="hide-mobile-col">' . $dataInicial . '</td>';
                                echo '<td class="ph2 hide-mobile-col">' . $dataFinal . '</td>';
                                echo '<td class="ph3 hide-mobile-col"><span class="badge" style="background-color: ' . $corGarantia . '; border-color: ' . $corGarantia . '">' . $vencGarantia . '</span> </td>';
                                echo '<td class="hide-mobile-col">R$ ' . number_format($r->totalProdutos + $r->totalServicos, 2, ',', '.') . '</td>';                                
                                echo '<td class="hide-mobile-col">R$ ' . number_format(floatval($r->desconto), 2, ',', '.') . '</td>';
                                echo '<td class="hide-mobile-col">R$ ' . number_format(floatval($r->valor_desconto), 2, ',', '.') . '</td>';
                                echo '<td class="ph4 hide-mobile-col">R$ ' . number_format($r->faturado ? floatval($r->valor_desconto) : 0.00, 2, ',', '.') . '</td>';
                                echo '<td><span class="badge" style="background-color: ' . $cor . '; border-color: ' . $cor . '">' . $r->status . '</span> </td>';
                                echo '<td class="mobile-actions">';

                                $editavel = $this->os_model->isEditable($r->idOs);

                                // Botão Visualizar (sempre visível em mobile e desktop)
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                    echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" class="btn-nwe mobile-action-btn" title="Ver mais detalhes"><i class="bx bx-show"></i><span class="hide-mobile-text"> Ver</span></a>';
                                }
                                // Outros botões apenas em desktop
                                echo '<span class="hide-mobile-col">';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                    echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/imprimir/' . $r->idOs . '" target="_blank" class="btn-nwe6" title="Imprimir A4"><i class="bx bx-printer bx-xs"></i></a>';
                                    echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/imprimirTermica/' . $r->idOs . '" target="_blank" class="btn-nwe6" title="Imprimir Não Fiscal"><i class="bx bx-printer bx-xs"></i></a>';
                                }
                                if ($editavel) {
                                    echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/editar/' . $r->idOs . '" class="btn-nwe3" title="Editar OS"><i class="bx bx-edit"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs') && $editavel) {
                                    echo '<a href="#modal-excluir" role="button" data-toggle="modal" os="' . $r->idOs . '" class="btn-nwe4" title="Excluir OS"><i class="bx bx-trash-alt"></i></a>  ';
                                }
                                echo '</span>';
                                echo '</td>';
                                echo '</tr>';
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php echo $this->pagination->create_links(); ?>

    <!-- Modal -->
    <div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/os/excluir" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Excluir OS</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idOs" name="id" value="" />
                <h5 style="text-align: center">Deseja realmente excluir esta OS?</h5>
            </div>
            <div class="modal-footer" style="display:flex;justify-content: center">
                <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
                    <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
                <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Função para converter data de YYYY-MM-DD para dd/mm/yy
        function convertDateToFormat(dateStr) {
            if (!dateStr) return '';
            var parts = dateStr.split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0].substring(2);
            }
            return dateStr;
        }
        
        // Converter valores antes de enviar o formulário
        $('#formFiltros').on('submit', function(e) {
            // Converter data inicial
            var data1 = $('#data').val();
            if (data1) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'data',
                    value: convertDateToFormat(data1)
                }).appendTo(this);
            }
            
            // Converter data final
            var data2 = $('#data2').val();
            if (data2) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'data2',
                    value: convertDateToFormat(data2)
                }).appendTo(this);
            }
        });
        
        $(document).on('click', 'a', function(event) {
            var os = $(this).attr('os');
            $('#idOs').val(os);
        });
        $(document).on('click', '#excluir-notificacao', function(event) {
            event.preventDefault();
            $.ajax({
                    url: '<?php echo site_url() ?>/os/excluir_notificacao',
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    if (data.result == true) {
                        Swal.fire({
                            type: "success",
                            title: "Sucesso",
                            text: "Notificação excluída com sucesso."
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            type: "success",
                            title: "Sucesso",
                            text: "Ocorreu um problema ao tentar exlcuir notificação."
                        });
                    }
                });
        });
        
        // Toggle filtros em mobile
        $('#btnToggleFiltros').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Só funciona em mobile (largura < 768px)
            if ($(window).width() >= 768) {
                return;
            }
            
            var $form = $('#formFiltros');
            var isVisible = $form.is(':visible') || $form.css('display') !== 'none';
            
            if (isVisible) {
                $form.slideUp(300, function() {
                    $form.css('display', 'none');
                });
                $(this).find('i').removeClass('bx-filter-alt').addClass('bx-filter');
            } else {
                $form.css('display', 'block');
                $form.hide().slideDown(300);
                $(this).find('i').removeClass('bx-filter').addClass('bx-filter-alt');
            }
        });
        
        // Garantir que o formulário apareça no desktop ao redimensionar
        $(window).on('resize', function() {
            if ($(window).width() >= 768) {
                $('#formFiltros').css('display', 'block');
            }
        });
    });
</script>
