<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class LancamentosController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('financeiro_model');
    }

    public function index_get($id = '')
    {
        $this->logged_user();
        if (! $this->permission->checkPermission($this->logged_user()->level, 'vLancamento')) {
            $this->response([
                'status'  => false,
                'message' => 'Você não está autorizado a visualizar lançamentos.',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }

        if (! $id) {
            $where     = $this->buildWhereFromParams();
            $perPage   = (int) ($this->get('perPage', true) ?: 20);
            $page      = (int) ($this->get('page', true) ?: 0);
            $start     = $page * $perPage;
            $lancamentos = $this->financeiro_model->getLancamentosApi($where, $perPage, $start);
            $totals    = $this->financeiro_model->getTotalsApi($where);

            $this->response([
                'status'  => true,
                'message' => 'Lista de Lançamentos',
                'result'  => $lancamentos ?: [],
                'totals'  => $totals,
            ], REST_Controller::HTTP_OK);
        }

        if ($id && is_numeric($id)) {
            $lancamento = $this->financeiro_model->getLancamentoById($id);

            if ($lancamento) {
                $this->response([
                    'status'  => true,
                    'message' => 'Detalhes do Lançamento',
                    'result'  => $lancamento,
                ], REST_Controller::HTTP_OK);
            }

            $this->response([
                'status'  => false,
                'message' => 'Lançamento não encontrado.',
                'result'  => null,
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response([
            'status'  => false,
            'message' => 'ID inválido.',
            'result'  => null,
        ], REST_Controller::HTTP_BAD_REQUEST);
    }

    public function index_post()
    {
        $this->logged_user();
        if (! $this->permission->checkPermission($this->logged_user()->level, 'aLancamento')) {
            $this->response([
                'status'  => false,
                'message' => 'Você não está autorizado a adicionar lançamentos.',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }

        $input = $this->getRequestBody();
        $msg   = $this->validarLancamento($input);
        if ($msg !== null) {
            $this->response([
                'status'  => false,
                'message' => $msg,
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $data = $this->montarDadosLancamento($input);

        if (! $this->financeiro_model->add('lancamentos', $data)) {
            $this->response([
                'status'  => false,
                'message' => 'Não foi possível criar o lançamento.',
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $lancamentoId = $this->db->insert_id();
        $lancamento   = $this->financeiro_model->getLancamentoById($lancamentoId);

        $this->log_app('Adicionou lançamento via API. ID: ' . $lancamentoId);

        $this->response([
            'status'  => true,
            'message' => 'Lançamento criado com sucesso!',
            'result'  => $lancamento,
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_put($id)
    {
        $this->logged_user();
        if (! $this->permission->checkPermission($this->logged_user()->level, 'eLancamento')) {
            $this->response([
                'status'  => false,
                'message' => 'Você não está autorizado a editar lançamentos.',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }

        if (! $id || ! is_numeric($id)) {
            $this->response([
                'status'  => false,
                'message' => 'ID do lançamento inválido.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $lancamento = $this->financeiro_model->getLancamentoById($id);
        if (! $lancamento) {
            $this->response([
                'status'  => false,
                'message' => 'Lançamento não encontrado.',
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $input = $this->getRequestBody();
        $msg   = $this->validarLancamento($input, true);
        if ($msg !== null) {
            $this->response([
                'status'  => false,
                'message' => $msg,
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $data = $this->montarDadosLancamento($input, true, $lancamento);

        if (! $this->financeiro_model->edit('lancamentos', $data, 'idLancamentos', $id)) {
            $this->response([
                'status'  => false,
                'message' => 'Não foi possível atualizar o lançamento.',
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $lancamento = $this->financeiro_model->getLancamentoById($id);

        $this->log_app('Editou lançamento via API. ID: ' . $id);

        $this->response([
            'status'  => true,
            'message' => 'Lançamento atualizado com sucesso!',
            'result'  => $lancamento,
        ], REST_Controller::HTTP_OK);
    }

    public function index_delete($id)
    {
        $this->logged_user();
        if (! $this->permission->checkPermission($this->logged_user()->level, 'dLancamento')) {
            $this->response([
                'status'  => false,
                'message' => 'Você não está autorizado a excluir lançamentos.',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }

        if (! $id || ! is_numeric($id)) {
            $this->response([
                'status'  => false,
                'message' => 'ID do lançamento inválido.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $lancamento = $this->financeiro_model->getLancamentoById($id);
        if (! $lancamento) {
            $this->response([
                'status'  => false,
                'message' => 'Lançamento não encontrado.',
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $this->db->trans_start();
        $this->db->where('lancamentos_id', $id)->update('vendas', ['lancamentos_id' => null, 'faturado' => 0, 'status' => 'Finalizado']);
        $this->db->where('lancamento', $id)->update('os', ['lancamento' => null]);
        $this->db->where('lancamento', $id)->update('propostas', ['lancamento' => null]);
        $this->db->where('lancamentos_id', $id)->delete('pagamentos_parciais');
        $this->financeiro_model->delete('lancamentos', 'idLancamentos', $id);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->response([
                'status'  => false,
                'message' => 'Erro ao excluir lançamento.',
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->log_app('Excluiu lançamento via API. ID: ' . $id);

        $this->response([
            'status'  => true,
            'message' => 'Lançamento excluído com sucesso!',
        ], REST_Controller::HTTP_OK);
    }

    /**
     * POST /api/v1/lancamentos/{id}/baixar
     * Registrar pagamento / baixar lançamento.
     */
    public function baixar_post($id)
    {
        $this->logged_user();
        if (! $this->permission->checkPermission($this->logged_user()->level, 'eLancamento')) {
            $this->response([
                'status'  => false,
                'message' => 'Você não está autorizado a editar lançamentos.',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }

        if (! $id || ! is_numeric($id)) {
            $this->response([
                'status'  => false,
                'message' => 'ID do lançamento inválido.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $lancamento = $this->financeiro_model->getLancamentoById($id);
        if (! $lancamento) {
            $this->response([
                'status'  => false,
                'message' => 'Lançamento não encontrado.',
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $input = $this->getRequestBody();
        $valor = isset($input['valor']) ? $this->parseValorMonetario($input['valor']) : 0;
        $dataPagamento = $input['data_pagamento'] ?? date('Y-m-d');
        $formaPgto     = $input['forma_pgto'] ?? ($lancamento->forma_pgto ?? '');
        $observacao    = $input['observacao'] ?? '';

        $valorLancamento = (float) ($lancamento->valor_desconto ?: $lancamento->valor);
        if ($valor <= 0) {
            $valor = $valorLancamento;
        }

        $dataPagamentoParsed = $this->parseData($dataPagamento) ?: date('Y-m-d');

        $this->load->model('pagamentos_parciais_model');
        $addResult = $this->pagamentos_parciais_model->add([
            'lancamentos_id'  => $id,
            'valor'           => $valor,
            'data_pagamento'  => $dataPagamentoParsed,
            'forma_pgto'      => $formaPgto,
            'observacao'      => $observacao ?: 'Pagamento via API',
            'usuarios_id'     => $this->logged_user()->usuario->idUsuarios,
        ]);

        if (! $addResult) {
            $this->response([
                'status'  => false,
                'message' => 'Não foi possível registrar o pagamento.',
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->financeiro_model->edit('lancamentos', [
            'data_pagamento' => $dataPagamentoParsed,
            'forma_pgto'     => $formaPgto,
        ], 'idLancamentos', $id);

        $this->log_app('Registrou pagamento via API. Lançamento ID: ' . $id);

        $lancamento = $this->financeiro_model->getLancamentoById($id);

        $this->response([
            'status'  => true,
            'message' => 'Pagamento registrado com sucesso!',
            'result'  => $lancamento,
        ], REST_Controller::HTTP_OK);
    }

    private function buildWhereFromParams()
    {
        $conditions = [];

        $from = $this->get('from', true) ?: $this->get('vencimento_de', true);
        $to   = $this->get('to', true) ?: $this->get('vencimento_ate', true);

        if ($from) {
            $d = $this->parseData($from);
            if ($d) {
                $conditions[] = ['data_vencimento >=', $d];
            }
        }
        if ($to) {
            $d = $this->parseData($to);
            if ($d) {
                $conditions[] = ['data_vencimento <=', $d];
            }
        }

        $tipo    = $this->get('tipo', true);
        $status  = $this->get('status', true);
        $cliente = trim($this->get('cliente', true));

        if ($tipo !== '' && $tipo !== null) {
            $conditions[] = ['tipo', $tipo];
        }
        if ($status !== '' && $status !== null) {
            $conditions[] = ['baixado', (int) $status];
        }
        if ($cliente) {
            $conditions[] = ['cliente_fornecedor LIKE', '%' . $this->db->escape_like_str($cliente) . '%'];
        }

        return $conditions;
    }

    private function parseValorMonetario($v)
    {
        if ($v === null || $v === '') {
            return 0.0;
        }
        if (is_numeric($v)) {
            return (float) $v;
        }
        return (float) str_replace(',', '.', (string) $v);
    }

    private function validarLancamento(array $input, $edicao = false)
    {
        if (! $edicao) {
            if (empty($input['descricao']) || trim($input['descricao']) === '') {
                return 'Descrição é obrigatória.';
            }
            $valor = isset($input['valor']) ? $this->parseValorMonetario($input['valor']) : 0;
            if ($valor <= 0) {
                return 'Valor deve ser maior que zero.';
            }
            if (empty($input['data_vencimento'])) {
                return 'Data de vencimento é obrigatória.';
            }
            $tipo = $input['tipo'] ?? '';
            if (! in_array($tipo, ['receita', 'despesa'], true)) {
                return 'Tipo deve ser "receita" ou "despesa".';
            }
            
            // Validar cliente/fornecedor: aceita ID (clientes_id) ou texto livre (cliente_fornecedor)
            $clienteId = isset($input['clientes_id']) && $input['clientes_id'] !== '' && $input['clientes_id'] !== null;
            $clienteFornecedor = isset($input['cliente_fornecedor']) && trim($input['cliente_fornecedor']) !== '';
            
            if (!$clienteId && !$clienteFornecedor) {
                return 'É necessário informar o cliente (clientes_id) ou fornecedor (cliente_fornecedor).';
            }
        }
        return null;
    }

    private function montarDadosLancamento(array $input, $edicao = false, $lancamentoAtual = null)
    {
        $parseValor = function ($v) {
            if ($v === null || $v === '') {
                return 0;
            }
            if (is_numeric($v)) {
                return (float) $v;
            }
            return (float) str_replace(',', '.', (string) $v);
        };

        $valor     = isset($input['valor']) ? $parseValor($input['valor']) : ($lancamentoAtual->valor ?? 0);
        $desconto  = isset($input['desconto']) ? $parseValor($input['desconto']) : ($lancamentoAtual->desconto ?? 0);
        $valorDesc = $valor - $desconto;
        if ($valorDesc < 0) {
            $valorDesc = 0;
        }

        $dataVenc = $this->parseData($input['data_vencimento'] ?? '') ?: ($lancamentoAtual->data_vencimento ?? date('Y-m-d'));
        $dataPag  = null;
        if (! empty($input['data_pagamento'])) {
            $dataPag = $this->parseData($input['data_pagamento']);
        }
        $baixado = isset($input['baixado']) ? (int) (bool) $input['baixado'] : ($lancamentoAtual->baixado ?? 0);

        $data = [
            'descricao'       => $input['descricao'] ?? ($lancamentoAtual->descricao ?? ''),
            'valor'           => $valor,
            'desconto'        => $desconto,
            'valor_desconto'  => $valorDesc,
            'tipo_desconto'   => $input['tipo_desconto'] ?? ($lancamentoAtual->tipo_desconto ?? 'real'),
            'data_vencimento' => $dataVenc,
            'data_pagamento'  => $dataPag,
            'baixado'         => $baixado,
            'cliente_fornecedor' => $input['cliente_fornecedor'] ?? ($lancamentoAtual->cliente_fornecedor ?? null),
            'forma_pgto'      => $input['forma_pgto'] ?? ($lancamentoAtual->forma_pgto ?? ''),
            'tipo'            => $input['tipo'] ?? ($lancamentoAtual->tipo ?? 'receita'),
            'observacoes'     => $input['observacoes'] ?? ($lancamentoAtual->observacoes ?? null),
            'usuarios_id'     => isset($input['usuarios_id']) ? (int) $input['usuarios_id'] : (int) $this->logged_user()->usuario->idUsuarios,
        ];

        if (isset($input['clientes_id'])) {
            $data['clientes_id'] = $input['clientes_id'] ? (int) $input['clientes_id'] : null;
        } elseif (! $edicao) {
            $data['clientes_id'] = $input['clientes_id'] ?? null;
        }

        if (isset($input['categorias_id'])) {
            $data['categorias_id'] = $input['categorias_id'] ? (int) $input['categorias_id'] : null;
        }
        if (isset($input['contas_id'])) {
            $data['contas_id'] = $input['contas_id'] ? (int) $input['contas_id'] : null;
        }

        $checkColumns = $this->db->query("SHOW COLUMNS FROM lancamentos WHERE Field IN ('valor_pago', 'status_pagamento')");
        if ($checkColumns->num_rows() > 0 && ! $edicao) {
            $data['valor_pago']       = $baixado ? $valorDesc : 0;
            $data['status_pagamento'] = $baixado ? 'pago' : 'pendente';
        }

        return $data;
    }

    private function parseData($str)
    {
        if (empty($str)) {
            return null;
        }
        if (preg_match('#^(\d{4})-(\d{2})-(\d{2})$#', $str)) {
            return $str;
        }
        if (preg_match('#^(\d{1,2})/(\d{1,2})/(\d{4})$#', $str, $m)) {
            return $m[3] . '-' . $m[2] . '-' . $m[1];
        }
        return null;
    }

    private function getRequestBody()
    {
        $raw = $this->input->raw_input_stream;
        if ($raw !== null && $raw !== '') {
            $dec = json_decode($raw, true);
            if (is_array($dec)) {
                return $dec;
            }
        }
        $method = strtoupper($this->input->method());
        if ($method === 'PUT') {
            return $this->put() ?: [];
        }
        if ($method === 'POST') {
            return $this->post() ?: [];
        }
        return [];
    }
}
