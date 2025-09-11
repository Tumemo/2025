<?php
header('Content-Type: application/json');

$scoresFile = 'scores.json';

// Função para ler os scores do arquivo JSON
function getScores($filename) {
    if (!file_exists($filename)) {
        return []; // Retorna array vazio se o arquivo não existir
    }
    $json_data = file_get_contents($filename);
    $scores = json_decode($json_data, true);
    // Garante que o retorno seja um array, mesmo se o JSON estiver vazio ou mal formatado
    return is_array($scores) ? $scores : [];
}

// Função para salvar os scores no arquivo JSON
function saveScores($filename, $scores) {
    // Ordena os scores antes de salvar (do maior para o menor)
    usort($scores, function($a, $b) {
        return $b['score'] - $a['score'];
    });
    // Mantém apenas os top 10
    $scores = array_slice($scores, 0, 10); 
    
    // Cria o diretório se não existir (útil em alguns ambientes de hospedagem)
    $dir = dirname($filename);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    if (file_put_contents($filename, json_encode($scores, JSON_PRETTY_PRINT)) === false) {
        // Log de erro, se necessário
        error_log("Erro ao escrever no arquivo de scores: " . $filename);
        return false; // Indica falha
    }
    return true; // Indica sucesso
}

// Verifica a ação solicitada
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'get_scores') {
    $scores = getScores($scoresFile);
    echo json_encode($scores);
} elseif ($action === 'save_score') {
    // Recebe os dados via POST (espera-se JSON do JavaScript)
    $data = json_decode(file_get_contents('php://input'), true);

    // Valida os dados recebidos
    if (isset($data['username']) && isset($data['score']) && $data['username'] !== '' && is_numeric($data['score'])) {
        $newScore = [
            'username' => htmlspecialchars(trim($data['username'])), // Protege contra XSS e remove espaços extras
            'score' => (int)$data['score'] // Garante que seja um inteiro
        ];

        // Verifica se o nome de usuário não está vazio após o trim
        if ($newScore['username'] === '') {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Nome de usuário inválido.']);
            exit;
        }

        $scores = getScores($scoresFile);

        // Verifica se já existe uma pontuação para este usuário e atualiza se for maior
        $userExists = false;
        foreach ($scores as $key => &$entry) { // Adicionado $key para poder atualizar o índice
            if ($entry['username'] === $newScore['username']) {
                if ($newScore['score'] > $entry['score']) {
                    $entry['score'] = $newScore['score'];
                }
                $userExists = true;
                // Atualiza o array $scores diretamente pela referência $entry
                $scores[$key] = $entry; 
                break; // Sai do loop assim que encontrar o usuário
            }
        }
        unset($entry); // Desvincula a referência

        // Se o usuário não existe, adiciona a nova pontuação
        if (!$userExists) {
            $scores[] = $newScore;
        }

        if (saveScores($scoresFile, $scores)) {
            echo json_encode(['status' => 'success', 'message' => 'Pontuação salva com sucesso!']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['status' => 'error', 'message' => 'Falha ao salvar pontuação no servidor.']);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos para salvar pontuação (username ou score ausente/inválido).']);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Ação inválida. Use "get_scores" ou "save_score".']);
}
?>