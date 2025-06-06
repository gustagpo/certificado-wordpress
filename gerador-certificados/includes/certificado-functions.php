<?php
/**
 * Funções auxiliares para o Gerador de Certificados
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Carrega os dados dos inscritos
 */
function gc_carregar_dados_inscritos() {
    $upload_dir = wp_upload_dir();
    $json_path = $upload_dir['basedir'] . '/inscritos.json';
    
    if (!file_exists($json_path)) {
        return new WP_Error('arquivo_nao_encontrado', 'Arquivo de inscritos não encontrado');
    }
    
    $dados = json_decode(file_get_contents($json_path), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('json_invalido', 'Erro ao decodificar o arquivo JSON');
    }
    
    return $dados;
}

/**
 * Gera o HTML do certificado
 */
function gc_gerar_html_certificado($nome) {
    $upload_dir = wp_upload_dir();
    $imagem_path = $upload_dir['basedir'] . '/modelo_certificado.jpg';
    
    $bg_style = '';
    if (file_exists($imagem_path)) {
        $image_info = getimagesize($imagem_path);
        if ($image_info !== false) {
            $imagem_data = base64_encode(file_get_contents($imagem_path));
            $bg_style = 'background-image: url("data:'.$image_info['mime'].';base64,'.$imagem_data.'");';
        }
    }
    
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            @page { margin: 0; size: A4 landscape; }
            body {
                margin: 0;
                padding: 0;
                width: 297mm;
                height: 210mm;
                position: relative;
                '.$bg_style.'
                background-size: cover;
                font-family: Helvetica, Arial, sans-serif;
            }
            .gc-nome-participante {
                position: absolute;
                top: 50%;
                left: 40%;
                width: 100%;
                text-align: left;
                transform: translateY(-50%);
                font-size: 18pt;
                font-weight: bold;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="gc-nome-participante">'.htmlspecialchars($nome, ENT_QUOTES, 'UTF-8').'</div>
    </body>
    </html>';
}