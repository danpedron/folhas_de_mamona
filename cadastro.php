<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Cadastrar Novo Local com Mamona</h4>
            </div>
            <div class="card-body">
                <form action="processa_cadastro.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" required 
                               placeholder="Ex: -23.550520" pattern="-?\d{1,3}\.\d{6,8}">
                        <small class="text-muted">Formato: -23.550520 (com 6-8 casas decimais)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" required
                               placeholder="Ex: -46.633308" pattern="-?\d{1,3}\.\d{6,8}">
                        <small class="text-muted">Formato: -46.633308 (com 6-8 casas decimais)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control" id="data" name="data" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (Opcional)</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Formatos aceitos: JPEG, PNG, etc. (máx. 2MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4" required
                                  placeholder="Descreva o local e as características da mamona encontrada"></textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cadastrar Local
                        </button>
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar para Listagem
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Validação básica do formulário no cliente
document.querySelector('form').addEventListener('submit', function(e) {
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    
    if (!/^-?\d{1,3}\.\d{6,8}$/.test(lat) || !/^-?\d{1,3}\.\d{6,8}$/.test(lng)) {
        alert('Por favor, insira coordenadas válidas com 6 a 8 casas decimais.');
        e.preventDefault();
    }
});
</script>

<?php
require_once 'includes/footer.php';
?>
