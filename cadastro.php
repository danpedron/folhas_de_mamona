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
                        <div class="input-group">
                            <input type="text" class="form-control" id="latitude" name="latitude" required 
                                   placeholder="Ex: -23.550520" pattern="-?\d{1,3}\.\d{6,8}">
                            <button class="btn btn-outline-secondary" type="button" id="btn-geolocation">
                                <i class="fas fa-location-arrow"></i> Auto
                            </button>
                        </div>
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
                        <input type="date" class="form-control" id="data" name="data" required
                               value="<?= date('Y-m-d') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (Opcional)</label>
                        
                        <!-- Área de preview -->
                        <div class="mb-2 text-center">
                            <img id="foto-preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
                                 alt="Preview da foto" class="img-thumbnail d-none" style="max-height: 200px;">
                        </div>
                        
                        <div class="btn-group w-100 mb-2">
                            <label class="btn btn-outline-primary" for="foto">
                                <i class="fas fa-camera"></i> Selecionar Foto
                                <input type="file" class="d-none" id="foto" name="foto" accept="image/*">
                            </label>
                            <button type="button" class="btn btn-outline-success" id="btn-paste-photo">
                                <i class="fas fa-paste"></i> Colar Foto
                            </button>
                        </div>
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

// Preview da foto selecionada
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.getElementById('foto-preview');
            preview.src = event.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

// Colar foto da área de transferência
document.getElementById('btn-paste-photo').addEventListener('click', async function() {
    try {
        const clipboardItems = await navigator.clipboard.read();
        for (const clipboardItem of clipboardItems) {
            for (const type of clipboardItem.types) {
                if (type.startsWith('image/')) {
                    const blob = await clipboardItem.getType(type);
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.getElementById('foto-preview');
                        preview.src = event.target.result;
                        preview.classList.remove('d-none');
                        
                        // Cria um arquivo para ser enviado no formulário
                        const file = new File([blob], 'pasted-image.png', { type: type });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        document.getElementById('foto').files = dataTransfer.files;
                    };
                    reader.readAsDataURL(blob);
                    return;
                }
            }
        }
        alert('Nenhuma imagem encontrada na área de transferência.');
    } catch (err) {
        console.error('Erro ao colar imagem:', err);
        alert('Erro ao acessar área de transferência. Certifique-se de que o site tem permissão para acessá-la.');
    }
});

// Geolocalização automática
document.getElementById('btn-geolocation').addEventListener('click', function() {
    const btn = this;
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Localizando...';
    btn.disabled = true;
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                latInput.value = position.coords.latitude.toFixed(8);
                lngInput.value = position.coords.longitude.toFixed(8);
                btn.innerHTML = '<i class="fas fa-location-arrow"></i> Auto';
                btn.disabled = false;
            },
            function(error) {
                let errorMessage;
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = "Permissão negada pelo usuário.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = "Localização indisponível.";
                        break;
                    case error.TIMEOUT:
                        errorMessage = "Tempo de espera excedido.";
                        break;
                    case error.UNKNOWN_ERROR:
                        errorMessage = "Erro desconhecido.";
                        break;
                }
                alert('Erro ao obter localização: ' + errorMessage);
                btn.innerHTML = '<i class="fas fa-location-arrow"></i> Auto';
                btn.disabled = false;
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    } else {
        alert("Geolocalização não é suportada por este navegador.");
        btn.innerHTML = '<i class="fas fa-location-arrow"></i> Auto';
        btn.disabled = false;
    }
});
</script>

<?php
require_once 'includes/footer.php';
?>
