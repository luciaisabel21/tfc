<?php
// Configuración de rutas base
define('BASE_PATH', __DIR__);
define('BASE_URL', 'https://tfc-cmct.onrender.com/DWES_P3_LUCIAI');

// Configuración de la base de datos
define('DB_HOST', getenv('DB_HOST') ?: 'dpg-d4om0ui4d50c73909keg-a');
define('DB_PORT', getenv('DB_PORT') ?: '5432');
define('DB_NAME', getenv('DB_NAME') ?: 'everlia');
define('DB_USER', getenv('DB_USER') ?: 'everlia_user');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '2mIbsUXJxMFFSIc15ZAbphqlC6Z4wX0c');