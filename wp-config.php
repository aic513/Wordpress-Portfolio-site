<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'portfolio_wp');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}Aj;2v)1KxG&WFL|`~f$&?1~fICkQ:vdSifT-&f;|XSWbrkFrCPi0XC q$/BZn+]');
define('SECURE_AUTH_KEY',  '[4QIE;_B=0c%c7M@{@oZ6pc/xB-n:zWh-nbIbV2:aO)30Jvt~~r]d }%^4w_Qc+p');
define('LOGGED_IN_KEY',    'x@|L0{_IW`$5wV+nlN?SdY7-0-0Oe`nVdDj:!Rs(J>e0D{hKi}Aim|Teo6:Om~TD');
define('NONCE_KEY',        'IESr&1t>)I&Y%KM~ ^bV0LERu}Q0u?DHcJ@.crDf3d@H|c_wSZo3HWfUKI-&-qzh');
define('AUTH_SALT',        '>DHR@#jzr0epeQv%1>)4j-++Hs1hb`80xrn5o&>]P3l;POh[7tK5N7,|@DH$Jl3h');
define('SECURE_AUTH_SALT', 'Lv<_V0!ulPo#2-49r-obh3JlG$fO5VB RB9+az)&:K>(SUS4>IwDw*(Y5u35la!Y');
define('LOGGED_IN_SALT',   'c`mNO@Ltp%+Bd(Tu|+Y;TD-;aa+#u$(,d$/%:&ka6W~SQ,6{cM3$-F*DL%&g0@G+');
define('NONCE_SALT',       'Ly*qj]r+T50*aoqNgbagNz.w|FxV3X^tbus~m 2+5t|sT*m%|Uoklhv0HQe-nlqt');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
