<?php

class ErrorHandler
{
    // Função privada para processar o erro
    private function setErro($body)
    {
        // Inicia o buffering de saída
        ob_start();

        // Exibe o valor do JSON bruto recebido
        echo "Valor do \$TRECO: " . htmlspecialchars($body) . "\n";

        // Decodifica o JSON recebido em um array associativo
        $data = json_decode($body, true);

        // Verifica se a decodificação foi bem-sucedida
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Erro ao decodificar JSON: " . json_last_error_msg();
            return ob_get_clean();
        }

        // Verifica o status de 'sucesso' no JSON
        if ($data['sucesso']) {
            echo "<br> Sucesso: TRUE";
        } else {
            echo "<br> Sucesso: FALSE";
        }

        echo "<br>";

        // Verifica se há erros e se 'erros' é um array
        if (isset($data['erros']) && is_array($data['erros'])) {
            foreach ($data['erros'] as $erro) {
                echo "Código de erro: " . htmlspecialchars($erro['codigo']) . ", Mensagem: " . htmlspecialchars($erro['mensagem']) . "<br>";
            }
        } else {
            echo "Não há erros.";
        }

        // Captura a saída do buffer e a armazena na variável $mensagem
        $mensagem = ob_get_clean();
        return $mensagem;
    }

    // Função pública para obter a mensagem de erro processada
    public function getErro($body)
    {
        // Chama a função setErro e captura a mensagem retornada
        $mensagem = $this->setErro($body);
        echo $mensagem;
    }

    // Função principal para simular o recebimento de um JSON do servidor
    public function principal()
    {
        // Finge que $body é um valor JSON vindo de um servidor
        $body = '{"cpf":null,"sucesso":false,"erros":[{"codigo":"E004","mensagem":"Valor inválido para o campo assuntosInteresse."},{"codigo":"E004","mensagem":"Valor inválido para o campo recursosAcessibilidade."}]}';
        $this->getErro($body);
    }
}

// Instância a classe e chama a função principal
$handler = new ErrorHandler();
$handler->principal();

?>
