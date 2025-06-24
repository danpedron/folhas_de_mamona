        <footer class="mt-5 text-center text-muted">
            <p>&copy; <?= date('Y') ?> - Sistema de Mapeamento de Mamona</p>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Função para abrir o mapa no aplicativo nativo
        function openMap(latitude, longitude) {
            // Verifica se é iOS
            if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                window.open(`maps://maps.google.com/maps?q=${latitude},${longitude}`);
            } else {
                // Assume Android ou outros dispositivos
                window.open(`https://maps.google.com/maps?q=${latitude},${longitude}`);
            }
        }
    </script>
</body>
</html>
