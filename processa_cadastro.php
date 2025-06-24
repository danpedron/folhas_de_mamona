<?php
require_once 'config.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validação básica no servidor
        $errors = [];
        
        // Validar coordenadas
        if (!preg_match('/^-?\d{1,3}\.\d{6,8}$/', $_POST['latitude'])) {
            $errors[] = 'Latitude inválida. Deve ter 6 a 8 casas decimais.';
        }
        
        if (!preg_match('/^-?\d{1,3}\.\d{6,8}$/', $_POST['longitude'])) {
            $errors[] = 'Longitude inválida. Deve ter 6 a 8 casas decimais.';
        }
        
        // Validar data
        if (empty($_POST['data'])) {
            $errors[] = 'Data é obrigatória.';
        }
        
        // Validar descrição
        if (empty($_POST['descricao'])) {
            $errors[] = 'Descrição é obrigatória.';
        }
        
        // Processar a foto se foi enviada
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Verificar tamanho máximo (2MB)
            if ($_FILES['foto']['size'] > 2097152) {
                $errors[] = 'A foto deve ter no máximo 2MB.';
            } else {
                // Ler o conteúdo do arquivo
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
            }
        }
        
        // Se não houver erros, inserir no banco de dados
        if (empty($errors)) {
            $sql = "INSERT INTO mamona (latitude, longitude, data, foto, descricao) 
                    VALUES (:latitude, :longitude, :data, :foto, :descricao)";
            
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':latitude', $_POST['latitude']);
            $stmt->bindParam(':longitude', $_POST['longitude']);
            $stmt->bindParam(':data', $_POST['data']);
            $stmt->bindParam(':foto', $foto, $foto !== null ? PDO::PARAM_LOB : PDO::PARAM_NULL);
            $stmt->bindParam(':descricao', $_POST['descricao']);
            
            if ($stmt->execute()) {
                // Redirecionar para a listagem com mensagem de sucesso
                header('Location: index.php?success=1');
                exit;
            } else {
                throw new Exception('Erro ao inserir no banco de dados.');
            }
        } else {
            // Se houver erros, mostrar para o usuário
            require_once 'includes/header.php';
            echo '<div class="alert alert-danger">';
            echo '<h5><i class="fas fa-exclamation-triangle"></i> Erros encontrados:</h5>';
            echo '<ul>';
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo '</ul>';
            echo '<a href="cadastro.php" class="btn btn-warning mt-2">Voltar e Corrigir</a>';
            echo '</div>';
            require_once 'includes/footer.php';
            exit;
        }
    } catch (PDOException $e) {
        require_once 'includes/header.php';
        echo '<div class="alert alert-danger">Erro no banco de dados: ' . $e->getMessage() . '</div>';
        echo '<a href="cadastro.php" class="btn btn-warning">Voltar</a>';
        require_once 'includes/footer.php';
        exit;
    }
} else {
    // Se alguém tentar acessar diretamente, redirecionar
    header('Location: cadastro.php');
    exit;
}
?>
