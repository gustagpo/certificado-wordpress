<?php
/*
Plugin Name: Gerador de Certificados
Description: Gera certificados em PDF a partir de CPF
Version: 1.0
Author: Dtec
*/

// Prevenção contra acesso direto
defined('ABSPATH') or die('Acesso negado!');

// Prevenção máxima contra headers sent
remove_action('shutdown', 'wp_ob_end_flush_all', 1);
add_action('init', function() {
    ob_start();
}, 0);

// Carrega o DOMPDF manualmente
require_once __DIR__ . '/dompdf/autoload.inc.php';

// Carrega as funções auxiliares
require_once __DIR__ . '/includes/certificado-functions.php';

// Shortcode para o formulário
add_shortcode('formulario_certificado', 'gc_certificado_form_shortcode');

/**
 * Shortcode para exibir o formulário de certificado
 */
function gc_certificado_form_shortcode() {
    // Processamento ANTES de qualquer HTML
    if (isset($_POST['buscar_certificado']) && !empty($_POST['cpf'])) {
        gc_gerar_certificado(sanitize_text_field($_POST['cpf']));
        return ''; // Saída vazia pois o PDF já foi enviado
    }

    // Apenas se não for submissão POST
    return '
    <div class="gc-certificado-form">
        <form method="post">
            <label for="gc-cpf">Digite seu CPF (somente números):</label>
            <input type="text" name="cpf" id="gc-cpf" required pattern="\d{11}" title="Digite 11 números sem pontuação">
            <button type="submit" name="buscar_certificado" class="gc-botao" style="margin-top: 20px;">Buscar Certificado</button>
        </form>
    </div>';
}

/**
 * Função principal para gerar o certificado
 * @param string $cpf CPF do participante
 */
function gc_gerar_certificado($cpf) {
    // Carrega os dados dos inscritos
    $inscritos = gc_carregar_dados_inscritos();
    
    if (is_wp_error($inscritos)) {
        wp_die($inscritos->get_error_message());
    }

    // Busca o participante pelo CPF
    $participante = null;
    foreach ($inscritos as $inscrito) {
        if ($inscrito['cpf'] === $cpf) {
            $participante = $inscrito;
            break;
        }
    }

    if (!$participante) {
        wp_die('CPF não encontrado na lista de participantes.');
    }

    // Verificação radical de headers
    if (headers_sent()) {
        die('Erro crítico: Headers já foram enviados. Verifique espaços em branco nos arquivos PHP.');
    }

    // Limpeza total de buffers
    while (ob_get_level()) {
        ob_end_clean();
    }

    try {
        // Configuração robusta do DOMPDF
        $dompdf = new \Dompdf\Dompdf([
            'enable_remote' => true,
            'enable_html5_parser' => true,
            'defaultFont' => 'helvetica'
        ]);
        
        $html = gc_gerar_html_certificado($participante['nome']);
        
        // Debug: Salvar HTML gerado
        // file_put_contents(__DIR__.'/debug.html', $html);
        
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        
        // Renderização com tratamento de erros
        $dompdf->render();
        
        // Verificação adicional do output
        $output = $dompdf->output();
        if (empty($output)) {
            throw new Exception('O conteúdo do PDF está vazio');
        }
        
        // Nome do arquivo sanitizado
        $nome_arquivo = 'certificado_' . gc_sanitizar_nome_arquivo($cpf) . '.pdf';
        
        // Enviar headers corretamente
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . strlen($output));
        
        // Saída limpa
        ob_clean();
        flush();
        echo $output;
        exit;
        
    } catch (Exception $e) {
        // Log de erro detalhado
        error_log('ERRO GERACAO PDF: ' . $e->getMessage());
        wp_die('Ocorreu um erro ao gerar o certificado. Por favor, tente novamente.');
    }
}

/**
 * Função específica para sanitizar nomes de arquivos
 * @param string $filename Nome do arquivo
 * @return string Nome sanitizado
 */
function gc_sanitizar_nome_arquivo($filename) {
    $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '', $filename);
    return $filename;
}