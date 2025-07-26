<?php
$mensajes = [];
$directorioDestino = __DIR__ . "/img/";

// Crear carpeta si no existe
if (!is_dir($directorioDestino)) {
    mkdir($directorioDestino, 0755, true);
}

// Procesamiento de archivos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagenes'])) {
    $imagenes = $_FILES['imagenes'];

    // Validar límite de archivos
    if (count($imagenes['name']) > 450) {
        $mensajes[] = "<div class='alert alert-danger'>❌ No puedes subir más de 450 archivos.</div>";
    } else {
        foreach ($imagenes['tmp_name'] as $index => $tmpName) {
            $nombreOriginal = pathinfo($imagenes['name'][$index], PATHINFO_FILENAME);
            $tipo = mime_content_type($tmpName);

            if (!in_array($tipo, ['image/jpeg', 'image/png'])) {
                $mensajes[] = "<div class='alert alert-warning'>❌ El archivo <strong>{$imagenes['name'][$index]}</strong> no es válido.</div>";
                continue;
            }

            // Crear imagen desde archivo original (con @ para evitar warning ICCP)
            if ($tipo === 'image/jpeg') {
                $imagen = @imagecreatefromjpeg($tmpName);
            } elseif ($tipo === 'image/png') {
                $imagen = @imagecreatefrompng($tmpName); // 👈 Solución al warning
            }

            if (!$imagen) {
                $mensajes[] = "<div class='alert alert-danger'>❌ Error al procesar <strong>{$imagenes['name'][$index]}</strong>.</div>";
                continue;
            }

            $rutaWebp = $directorioDestino . $nombreOriginal . ".webp";

            // Convertir a WebP
            if (imagewebp($imagen, $rutaWebp, 80)) {
                $mensajes[] = "<div class='alert alert-success'>✅ <strong>{$imagenes['name'][$index]}</strong> convertida correctamente a WebP.</div>";
            } else {
                $mensajes[] = "<div class='alert alert-danger'>❌ Error al guardar <strong>{$imagenes['name'][$index]}</strong>.</div>";
            }

            imagedestroy($imagen);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Convertidor de Imágenes a WebP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Subir y Convertir Imágenes a WebP</h4>
        </div>
        <div class="card-body">
            <?php foreach ($mensajes as $msg) echo $msg; ?>

            <form action="subir.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="imagenes" class="form-label">Selecciona hasta 450 imágenes (JPEG o PNG)</label>
                    <input type="file" name="imagenes[]" multiple accept="image/jpeg,image/png" class="form-control"
                           onchange="if(this.files.length > 450){ alert('Máximo 450 archivos'); this.value=''; }" required>
                </div>
                <button type="submit" class="btn btn-success">Subir y Convertir</button>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <h5>Imágenes convertidas:</h5>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-3">
            <?php
            $archivos = glob("img/*.webp");
            foreach ($archivos as $img) {
                $nombre = basename($img);
                echo "
                <div class='col'>
                    <div class='card shadow-sm'>
                        <img src='$img' class='card-img-top' alt='$nombre'>
                        <div class='card-body'>
                            <p class='card-text text-center'>$nombre</p>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>