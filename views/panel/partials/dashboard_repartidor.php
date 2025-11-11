<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel del Repartidor - Belleza Glam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Paleta provisional, lista para personalizar */
            --rosa-claro: #fce4ec;
            --rosa-principal: #f48fb1;
            --rosa-oscuro: #ec407a;
            --gris-texto: #4a4a4a;
            --blanco: #ffffff;
        }

        body {
            background-color: var(--rosa-claro);
            font-family: 'Segoe UI', sans-serif;
            color: var(--gris-texto);
        }

        h2 {
            font-weight: 600;
            color: var(--rosa-oscuro);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .container-custom {
            padding: 40px 20px;
        }

        .list-group-item {
            background-color: var(--blanco);
            margin-bottom: 12px;
            border-radius: 12px;
            border-left: 5px solid var(--rosa-principal);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .list-group-item:hover {
            background-color: #fdeef3;
            transform: scale(1.01);
        }

        .badge-time {
            background-color: var(--rosa-oscuro);
            color: var(--blanco);
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .icon {
            margin-right: 8px;
            font-size: 1.3rem;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, var(--rosa-principal), var(--rosa-oscuro));
            color: var(--blanco);
            font-weight: 600;
            font-size: 1.1rem;
            padding: 14px 18px;
        }

        @media (max-width: 768px) {
            .container-custom {
                padding: 20px 10px;
            }

            .badge-time {
                font-size: 0.8rem;
                padding: 4px 8px;
            }
        }
    </style>
</head>

<body>

    <div class="container container-custom">
        <div class="card">
            <div class="card-header text-center">
                🚚 Pedidos Asignados - Belleza Glam
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div><span class="icon">💄</span>Pedido #2031 - Av. Libertad 456</div>
                        <span class="badge-time">14:15 hs</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div><span class="icon">💅</span>Pedido #2032 - Calle Flores 210</div>
                        <span class="badge-time">15:00 hs</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div><span class="icon">🧴</span>Pedido #2033 - B° Jardín 12</div>
                        <span class="badge-time">15:45 hs</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>