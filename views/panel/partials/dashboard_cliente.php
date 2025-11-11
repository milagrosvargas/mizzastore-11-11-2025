<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel del Cliente - Belleza Glam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Paleta provisional (puedes reemplazar con la tuya personalizada) */
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
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            transition: transform 0.2s ease-in-out;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
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
            background-color: var(--blanco);
            margin-bottom: 6px;
            border-radius: 8px;
            padding: 10px 14px;
            border-left: 4px solid var(--rosa-principal);
        }

        .container-custom {
            padding: 40px 20px;
        }

        .btn-rosa {
            background-color: var(--rosa-principal);
            color: var(--blanco);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-rosa:hover {
            background-color: var(--rosa-oscuro);
            transform: scale(1.02);
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
        <h2 class="mb-4 text-center">🌸 ¡Bienvenida, Laura! Este es tu espacio Belleza Glam</h2>

        <div class="row">
            <!-- Promoción destacada -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">🎁 Promoción del Día</div>
                    <div class="card-body">
                        <h5 class="card-title">2x1 en Labiales "Velvet Kiss" 💄</h5>
                        <p class="card-text">Solo por hoy hasta las 22 hs. ¡Deslumbra con tu mejor sonrisa!</p>
                        <button class="btn btn-rosa">Aprovechar oferta</button>
                    </div>
                </div>
            </div>

            <!-- Últimos pedidos -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">🧾 Tus Últimos Pedidos</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">#3041 - Serum Facial Rosa Mosqueta</li>
                            <li class="list-group-item">#3039 - Crema Hidratante “Glow Touch”</li>
                        </ul>
                        <div class="mt-3 text-end">
                            <button class="btn btn-rosa">Ver historial completo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recomendaciones personalizadas -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">💅 Recomendaciones para Ti</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2801/2801044.png" class="card-img-top p-4" alt="Mascarilla facial">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Mascarilla Facial Hidratante</h6>
                                        <p class="card-text">Ideal para piel seca o sensible 💧</p>
                                        <button class="btn btn-rosa btn-sm">Ver producto</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2801/2801152.png" class="card-img-top p-4" alt="Perfume floral">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Perfume Floral “Bloom Essence”</h6>
                                        <p class="card-text">Fresco, elegante y duradero 🌸</p>
                                        <button class="btn btn-rosa btn-sm">Ver producto</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2801/2801072.png" class="card-img-top p-4" alt="Set de brochas">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Set de Brochas Profesional</h6>
                                        <p class="card-text">12 piezas suaves y precisas ✨</p>
                                        <button class="btn btn-rosa btn-sm">Ver producto</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>