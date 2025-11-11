<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mizza Store | Panel Administrativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --rosa-principal: #e91e63;
            --rosa-suave: #f8bbd0;
            --rosa-claro: #fff5f8;
            --morado: #b388eb;
            --texto: #333;
            --blanco: #fff;
        }

        /* 🔹 CONTENEDOR CENTRAL */
        .dashboard-container {
            max-width: 1200px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 2.2rem;
            color: var(--rosa-principal);
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        p.subtitle {
            color: #777;
            text-align: center;
            margin-bottom: 40px;
            font-size: 1rem;
        }

        /* 🌸 Tarjetas de estadísticas principales */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            justify-content: center;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--blanco);
            border-radius: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            padding: 25px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--rosa-principal);
            margin-bottom: 15px;
        }

        .stat-card h2 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
        }

        .stat-card p {
            margin-top: 5px;
            color: #666;
            font-size: 0.95rem;
        }

        /* ✨ Panel inferior */
        .panel-sections {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
        }

        .section {
            flex: 1 1 48%;
            background: var(--blanco);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            min-width: 300px;
            text-align: left;
        }

        .section h3 {
            color: var(--rosa-principal);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .section ul li {
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
            font-size: 0.95rem;
            color: #555;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section ul li span {
            background: var(--rosa-suave);
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            color: var(--rosa-principal);
        }

        /* 💅 Mini gráfico decorativo */
        .chart {
            height: 120px;
            background: linear-gradient(135deg, var(--rosa-principal) 0%, var(--morado) 100%);
            border-radius: 14px;
            position: relative;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .chart::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60%;
            background: url('https://www.svgrepo.com/show/429773/graph-line.svg') center/cover no-repeat;
            opacity: 0.15;
        }

        /* 📱 Responsivo */
        @media (max-width: 768px) {
            .panel-sections {
                flex-direction: column;
                align-items: center;
            }

            .section {
                flex: 1 1 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <!-- 🌸 Estadísticas principales -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">💄</div>
                <h2>$12.480</h2>
                <p>Ventas Totales</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <h2>128</h2>
                <p>Productos en Stock</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🛍️</div>
                <h2>15</h2>
                <p>Pedidos Pendientes</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👩‍💼</div>
                <h2>93</h2>
                <p>Clientes Activos</p>
            </div>
        </div>

        <!-- 📊 Panel de información inferior -->
        <div class="panel-sections">
            <div class="section">
                <h3>📈 Rendimiento semanal</h3>
                <ul>
                    <li>Lunes <span>$8.200</span></li>
                    <li>Martes <span>$9.640</span></li>
                    <li>Miércoles <span>$10.100</span></li>
                    <li>Jueves <span>$11.450</span></li>
                    <li>Viernes <span>$13.220</span></li>
                </ul>
            </div>

            <div class="section">
                <h3>💬 Actividad reciente</h3>
                <ul>
                    <li>Nuevo registro de cliente <span>hace 2h</span></li>
                    <li>Pedido #4023 confirmado <span>hace 3h</span></li>
                    <li>Producto “Glow Tint” restockeado <span>hace 5h</span></li>
                    <li>Comentario positivo de <b>@milavargas</b> <span>hace 7h</span></li>
                    <li>Descuento activado en “Lip Set” <span>hace 9h</span></li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>