<?php

const API_URL = "https://whenisthenextmcufilm.com/api";
$ch = curl_init(API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 📌 Solución para Render: Desactivar la verificación estricta de SSL en el contenedor
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);
$data = json_decode($result, true);

curl_close($ch); // Buena práctica: Cerrar la conexión cURL

?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Próxima película de Marvel</title>
    <meta name="description" content="Descubre cuál es la próxima película de Marvel que se estrenará.">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
    
    <style>
        /* Centrado del contenido principal */
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: center;
            min-height: 90vh;
        }

        /* Botón */
        .theme-switcher {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .btn-minimal {
            background: transparent;
            border: none;
            color: var(--pico-muted-color); /* Usa el color de texto atenuado nativo de Pico */
            padding: 8px 12px;
            font-size: 0.85rem;
            cursor: pointer;
            box-shadow: none;
            transition: color 0.2s ease, opacity 0.2s ease;
            opacity: 0.6;
        }

        /* Al pasar el mouse, recupera un poco de visibilidad*/
        .btn-minimal:hover {
            background: transparent;
            color: var(--pico-color);
            box-shadow: none;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="theme-switcher">
        <button id="theme-toggle" class="btn-minimal">🌓 Tema</button>
    </div>

    <main>
        <h1>¿Cuándo se estrena la próxima película de Marvel?</h1>

        <?php if ($data && !isset($data['error'])): ?>
            <section>
                <img src="<?= $data["poster_url"]; ?>" width="300" alt="Poster de la próxima película de Marvel" style="border-radius: 16px; box-shadow: 0px 10px 35px rgba(0,0,0,0.2);" />
            </section>

            <hgroup>
                <h3><?= $data["title"]; ?> se estrena en <?= $data["days_until"]; ?> día(s)</h3>
                <p>Fecha de estreno: <?= $data["release_date"]; ?></p>
                <p><strong>La siguiente producción es:</strong> <?= $data["following_production"]["title"]; ?></p>
            </hgroup> 
        <?php else: ?>
            <section style="padding: 20px; max-width: 500px;">
                <p>🍿 No pudimos conectar con el universo Marvel en este momento, pero los servidores están trabajando en ello. ¡Inténtalo de nuevo en unos instantes!</p>
            </section>
        <?php endif; ?>
    </main>

    <script>
        const button = document.getElementById('theme-toggle');
        const html = document.documentElement;

        button.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
        });
    </script>
</body>
</html>