<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locais com Mamona</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .location-card {
            transition: transform 0.2s;
            margin-bottom: 15px;
        }
        .location-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .map-link {
            text-decoration: none;
            color: inherit;
        }
        .map-link:hover {
            color: inherit;
        }
        .descricao {
            white-space: pre-line;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <header class="mb-4">
            <h1 class="text-center"><i class="fas fa-map-marker-alt"></i> Locais com Mamona</h1>
            <p class="text-center text-muted">Listagem de locais onde foi encontrada mamona</p>
        </header>
