# 🖼️ Convertidor de Imágenes a WebP en PHP

Este proyecto permite subir y convertir hasta 450 imágenes en formato JPG, JPEG o PNG a WebP de forma automática usando PHP. Ideal para optimizar imágenes y mejorar el rendimiento de sitios web.

---

## 🚀 Características

- Conversión automática de imágenes JPG, JPEG y PNG a WebP  
- Soporta hasta 450 imágenes en un solo formulario  
- Compatible con PHP versiones 7.4.33, 8.1, 8.2, 8.3 y 8.4  
- Compatible con extensiones GD o Imagick para procesamiento de imágenes  
- Validación de formatos y tamaños  
- Código sencillo para integrar y personalizar  

---

## ⚙️ Requisitos y configuración recomendada de PHP

Para poder procesar hasta 450 imágenes sin problemas, es necesario configurar algunos parámetros en el archivo `php.ini` de tu entorno local o servidor:

<img width="1346" height="679" alt="image" src="https://github.com/user-attachments/assets/27a98401-a2b5-4116-90a7-fde5290999e9" />

```ini
; Permite subir hasta 500 archivos en un mismo formulario
max_file_uploads = 500

; Tamaño máximo permitido por archivo (ajustar según peso promedio)
upload_max_filesize = 5M

; Tamaño máximo permitido para toda la petición POST (archivos + datos)
post_max_size = 2048M

; Número máximo de variables aceptadas en una solicitud (opcional)
max_input_vars = 5000

; Tiempo máximo para ejecutar el script PHP (en segundos, opcional)
max_execution_time = 300

; Límite de memoria para el script PHP (necesario para procesamiento de imágenes)
memory_limit = 2048M
