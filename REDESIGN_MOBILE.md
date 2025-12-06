# Redesign Mobile - Análise de Páginas e Formulários Prioritários

## 📱 Objetivo
Melhorar a experiência de uso do sistema em dispositivos móveis (smartphones e tablets) através de redesign responsivo de páginas e formulários críticos.

---

## 🎯 Páginas e Formulários Prioritários

### **PRIORIDADE ALTA** ⚠️

#### 1. **Ordem de Serviço (OS)**
**Arquivos:**
- `application/views/os/adicionarOs.php`
- `application/views/os/editarOs.php`
- `application/views/os/os.php` (listagem)
- `application/views/os/visualizarOs.php`

**Problemas Identificados:**
- Uso extensivo de classes `span6`, `span3`, `span4` (Bootstrap 2) que não são responsivas
- Formulário muito longo com múltiplas colunas lado a lado
- Campos de data, status e garantia em múltiplas colunas que quebram em mobile
- Tabela de serviços/produtos com muitas colunas
- Editor WYSIWYG (Trumbowyg) pode não funcionar bem em mobile
- Botões pequenos e difíceis de clicar
- Modal de adicionar/editar serviço pode não ser responsivo

**Melhorias Necessárias:**
- Converter para Bootstrap 3/4/5 com grid responsivo (col-md, col-sm, col-xs)
- Empilhar campos verticalmente em telas pequenas
- Aumentar área de toque dos botões (mínimo 44x44px)
- Simplificar editor de texto ou usar textarea simples em mobile
- Tabelas responsivas com scroll horizontal ou cards em mobile
- Melhorar espaçamento entre campos
- Inputs com font-size adequado (mínimo 16px para evitar zoom automático)

---

#### 2. **Produtos**
**Arquivos:**
- `application/views/produtos/adicionarProduto.php`
- `application/views/produtos/editarProduto.php`
- `application/views/produtos/produtos.php` (listagem)
- `application/views/produtos/visualizarProduto.php`

**Problemas Identificados:**
- Formulário com campos lado a lado (código de barras, descrição, preço, etc.)
- Campos fiscais (NCM, CEST, CFOP) em múltiplas colunas
- Tabela de listagem com muitas colunas
- Botões de ação pequenos
- Campos de preço com máscara podem ser problemáticos em mobile

**Melhorias Necessárias:**
- Layout em coluna única para mobile
- Agrupar campos relacionados em seções colapsáveis
- Tabela responsiva ou cards para listagem
- Botões maiores e mais espaçados
- Inputs numéricos com teclado numérico (`inputmode="numeric"`)

---

#### 3. **Clientes**
**Arquivos:**
- `application/views/clientes/adicionarCliente.php`
- `application/views/clientes/editarCliente.php`
- `application/views/clientes/clientes.php` (listagem)
- `application/views/clientes/visualizar.php`

**Problemas Identificados:**
- Formulário dividido em duas colunas (`span6`)
- Campos de endereço, contato e dados fiscais lado a lado
- Validação de CPF/CNPJ pode ser problemática em mobile
- Tabela de listagem com muitas colunas
- Botão "Buscar CNPJ" pequeno

**Melhorias Necessárias:**
- Layout vertical em mobile
- Agrupar campos em seções (Dados Pessoais, Endereço, Contato, etc.)
- Melhorar botão de busca CNPJ (maior, mais visível)
- Tabela responsiva
- Máscaras de input otimizadas para mobile

---

#### 4. **Vendas**
**Arquivos:**
- `application/views/vendas/adicionarVenda.php`
- `application/views/vendas/editarVenda.php`
- `application/views/vendas/vendas.php` (listagem)
- `application/views/vendas/visualizarVenda.php`

**Problemas Identificados:**
- Formulário inicial com múltiplas colunas
- Seleção de produtos/serviços pode ser complexa em mobile
- Cálculo de totais e descontos
- Tabela de itens da venda

**Melhorias Necessárias:**
- Layout simplificado em mobile
- Busca de produtos otimizada (autocomplete maior)
- Campos de quantidade e preço mais fáceis de editar
- Visualização clara de totais
- Botões de ação mais acessíveis

---

### **PRIORIDADE MÉDIA** ⚠️

#### 5. **Notas de Entrada**
**Arquivos:**
- `application/views/notasentrada/adicionar_nota.php`
- `application/views/notasentrada/notas_entrada.php` (listagem)
- `application/views/notasentrada/visualizar_nota.php`

**Problemas Identificados:**
- Tabs podem ser pequenas em mobile
- Formulário de busca SEFAZ com campos longos
- Tabela de itens da nota
- Upload de arquivo pode ser problemático

**Melhorias Necessárias:**
- Tabs maiores ou menu dropdown em mobile
- Campos de busca mais espaçados
- Melhor feedback visual durante upload
- Tabela responsiva

---

#### 6. **Serviços**
**Arquivos:**
- `application/views/servicos/adicionarServico.php`
- `application/views/servicos/editarServico.php`
- `application/views/servicos/servicos.php` (listagem)

**Problemas Identificados:**
- Formulário simples mas pode ter campos lado a lado
- Tabela de listagem

**Melhorias Necessárias:**
- Layout vertical
- Tabela responsiva

---

#### 7. **Configurações do Sistema**
**Arquivos:**
- `application/views/mapos/configurar.php`

**Problemas Identificados:**
- Múltiplas tabs com muitos campos
- Formulário de certificado digital
- Campos de configuração em múltiplas colunas

**Melhorias Necessárias:**
- Tabs responsivas
- Layout vertical
- Upload de certificado otimizado

---

### **PRIORIDADE BAIXA** ℹ️

#### 8. **Relatórios**
**Arquivos:**
- `application/views/relatorios/rel_*.php`

**Problemas Identificados:**
- Filtros em múltiplas colunas
- Visualização de relatórios em PDF pode ser problemática

**Melhorias Necessárias:**
- Filtros empilhados
- Melhor visualização de PDFs em mobile

---

#### 9. **Usuários**
**Arquivos:**
- `application/views/usuarios/adicionarUsuario.php`
- `application/views/usuarios/editarUsuario.php`
- `application/views/usuarios/usuarios.php`

**Problemas Identificados:**
- Formulário com campos lado a lado
- Seleção de permissões pode ser complexa

**Melhorias Necessárias:**
- Layout vertical
- Seleção de permissões otimizada

---

## 🛠️ Padrões de Melhoria a Implementar

### 1. **Grid System**
- **Atual:** Bootstrap 2 (`span6`, `span3`, etc.)
- **Novo:** Bootstrap 3/4/5 ou CSS Grid/Flexbox
- **Exemplo:**
  ```html
  <!-- Antes -->
  <div class="span6">...</div>
  
  <!-- Depois -->
  <div class="col-md-6 col-12">...</div>
  ```

### 2. **Inputs e Formulários**
- Font-size mínimo de 16px para evitar zoom automático no iOS
- `inputmode` apropriado (numeric, email, tel, etc.)
- Labels sempre visíveis e claros
- Espaçamento adequado entre campos (mínimo 16px)
- Botões com área de toque mínima de 44x44px

### 3. **Tabelas**
- Scroll horizontal em mobile OU
- Conversão para cards/listas em mobile
- Headers fixos quando possível

### 4. **Navegação**
- Menu hambúrguer em mobile
- Tabs maiores ou dropdown em telas pequenas
- Breadcrumbs quando necessário

### 5. **Modais**
- Full-screen em mobile ou
- Modal responsivo com scroll interno
- Botões de ação sempre visíveis

### 6. **Botões**
- Tamanho mínimo: 44x44px
- Espaçamento adequado entre botões
- Ícones maiores em mobile
- Feedback visual claro

### 7. **Tipografia**
- Tamanhos de fonte legíveis (mínimo 14px para corpo)
- Hierarquia clara
- Contraste adequado (WCAG AA)

---

## 📋 Checklist de Implementação

### Fase 1: OS (Ordem de Serviço)
- [ ] Converter grid system em `adicionarOs.php`
- [ ] Converter grid system em `editarOs.php`
- [ ] Melhorar tabela de serviços/produtos
- [ ] Otimizar modais de adicionar/editar serviço
- [ ] Ajustar editor de texto para mobile
- [ ] Melhorar botões e área de toque
- [ ] Testar em diferentes tamanhos de tela

### Fase 2: Produtos
- [ ] Converter grid system
- [ ] Layout vertical em mobile
- [ ] Tabela responsiva
- [ ] Melhorar campos de preço
- [ ] Testar em diferentes tamanhos de tela

### Fase 3: Clientes
- [ ] Converter grid system
- [ ] Layout vertical
- [ ] Agrupar campos em seções
- [ ] Tabela responsiva
- [ ] Testar em diferentes tamanhos de tela

### Fase 4: Vendas
- [ ] Converter grid system
- [ ] Simplificar layout
- [ ] Melhorar busca de produtos
- [ ] Tabela de itens responsiva
- [ ] Testar em diferentes tamanhos de tela

### Fase 5: Outras Páginas
- [ ] Notas de Entrada
- [ ] Serviços
- [ ] Configurações
- [ ] Relatórios
- [ ] Usuários

---

## 🎨 Considerações de Design

1. **Mobile First:** Desenvolver primeiro para mobile, depois expandir para desktop
2. **Touch Targets:** Todos os elementos clicáveis devem ter pelo menos 44x44px
3. **Performance:** Minimizar JavaScript pesado em mobile
4. **Acessibilidade:** Manter contraste e navegação por teclado
5. **Consistência:** Manter padrões visuais consistentes

---

## 📱 Breakpoints Sugeridos

- **Mobile:** < 768px (xs, sm)
- **Tablet:** 768px - 1024px (md)
- **Desktop:** > 1024px (lg, xl)

---

## 🔍 Ferramentas de Teste

- Chrome DevTools (Device Toolbar)
- Firefox Responsive Design Mode
- Testes em dispositivos reais (iOS, Android)
- BrowserStack ou similar para testes cross-browser

---

## 📝 Notas

- Manter compatibilidade com versões antigas do sistema
- Testar todas as funcionalidades após cada mudança
- Documentar mudanças significativas
- Considerar feedback dos usuários durante implementação

---

**Última atualização:** 2025-01-XX
**Branch:** `feature/redesign-mobile`

