<?php
// ** Opciones de MySQL ** //
define('DB_NAME', 'db496378487');    // The name of the database
define('DB_USER', 'dbo496378487');     // Your MySQL username
define('DB_PASSWORD', 'mallrats'); // ...and password
define('DB_HOST', 'db496378487.db.1and1.com');    // 99% chance you won't need to change this value
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');


// Cambia SECRET_KEY a una frase única.  No tendrás que recordarla después,
// asi que hazla larga y complicada. Visita https://www.grc.com/passwords.htm
// para crear  una clave larga, o pon la que quieras.
define('SECRET_KEY', 'O1prsSofHn1zRnZMsaiPC9hdIITxA1ksvWRQDZyi88CWtiXcEnC6ojTapeCiKEC'); // Cambia esto a una frase única.

// Puedes tener varias instalaciones en una sola base de datos si les das un prefijo único
$table_prefix  = 'wp_';   // Solo numeros, letras y subrayado!

// Cambia esto para traducir WordPress.  Un fichero MO para el
// idioma elegido debe instalarse en wp-content/languages.
// Por ejemplo, instalad de.mo en wp-content/languages y establece WPLANG a 'de'
// para tenerlo en aleman.
define ('WPLANG', 'es_ES');

/* Eso es todo, deja de modificar cosas. Buen blogging. */

define('ABSPATH', dirname(__FILE__).'/');
require_once(ABSPATH.'wp-settings.php');
?>