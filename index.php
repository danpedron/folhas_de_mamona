<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="d-grid gap-2 mb-4">
    <a href="cadastro.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Cadastrar Novo Local
    </a>
</div>

<?php
try {
    // Query para buscar os locais ordenados por data (mais novos primeiro)
    $sql = "SELECT id, latitude, longitude, data, descricao 
            FROM mamona 
            ORDER BY data DESC, id DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $locais = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($locais) > 0) {
        echo '<div class="row">';
        
        foreach ($locais as $local) {
            // Converter o BLOB de descrição para string
            $descricao = '';
            if (!empty($local['descricao'])) {
                $descricao = is_resource($local['descricao']) ? 
                    stream_get_contents($local['descricao']) : 
                    $local['descricao'];
            }
            
            echo '<div class="col-md-6 col-lg-4">';
            echo '<div class="card location-card">';
            echo '<a href="javascript:void(0);" onclick="openMap('.$local['latitude'].','.$local['longitude'].')" class="map-link">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><i class="fas fa-calendar-day"></i> '.date('d/m/Y', strtotime($local['data'])).'</h5>';
            echo '<p class="card-text descricao">'.htmlspecialchars($descricao).'</p>';
            echo '<small class="text-muted"><i class="fas fa-map-pin"></i> '.$local['latitude'].', '.$local['longitude'].'</small>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
    } else {
        echo '<div class="alert alert-info text-center">Nenhum local com mamona encontrado.</div>';
    }
} catch(PDOException $e) {
    echo '<div class="alert alert-danger">Erro ao buscar locais: ' . $e->getMessage() . '</div>';
}

require_once 'includes/footer.php';
?>
