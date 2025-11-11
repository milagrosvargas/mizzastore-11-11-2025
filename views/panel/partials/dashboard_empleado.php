<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Empleado - Belleza Glam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Paleta provisional (se reemplazará con tu paleta personalizada) */
            --rosa-claro: #fce4ec;
            --rosa-principal: #f48fb1;
            --rosa-oscuro: #ec407a;
            --gris-texto: #4a4a4a;
            --blanco: #ffffff;
        }

        body {
            background: var(--rosa-claro);
            font-family: 'Segoe UI', sans-serif;
            color: var(--gris-texto);
        }

        h2 {
            font-weight: bold;
            color: var(--rosa-oscuro);
            text-align: center;
            margin-bottom: 2rem;
        }

        .card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            border: none;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(90deg, var(--rosa-principal), var(--rosa-oscuro));
            color: var(--blanco);
            font-weight: 600;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .list-group-item {
            border: none;
            background-color: #fff;
            margin-bottom: 6px;
            border-radius: 8px;
            padding: 10px 14px;
            border-left: 4px solid var(--rosa-principal);
        }

        .container-custom {
            padding: 40px 20px;
        }

        .card-text {
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .container-custom {
                padding: 20px 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container container-custom">
        <h2>💅 ¡Hola, Carla! Este es tu panel de empleada</h2>

        <div class="row">
            <!-- Turno de hoy -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">🕒 Tu turno de hoy</div>
                    <div class="card-body">
                        <p class="card-text">⏰ 10:00 - 18:00 hs</p>
                        <p class="card-text">📍 Sucursal: Belleza Glam - Centro</p>
                    </div>
                </div>
            </div>

            <!-- Tareas asignadas -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">🧴 Tareas del día</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Organizar productos en góndola</li>
                            <li class="list-group-item">Actualizar etiquetas de precios</li>
                            <li class="list-group-item">Atender consultas de clientas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pedidos o servicios en curso -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">💄 Servicios en curso</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">#402 - Maquillaje social (María G.)</li>
                            <li class="list-group-item">#403 - Tratamiento facial (Laura T.)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>