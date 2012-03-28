<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	Copyright (c) 2011 Lonnie Ezell

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

$lang['db_maintenance']			= 'Бекап';
$lang['db_backups']				= 'Архивы';

$lang['db_backup_warning']		= 'Note: Due to the limited execution time and memory available to PHP, backing up very large databases may not be possible. If your database is very large you might need to backup directly from your SQL server via the command line, or have your server admin do it for you if you do not have root privileges.';
$lang['db_filename']			= 'Название файла';

$lang['db_drop_question']		= 'Добавить &lsquo;Drop Table&rsquo; в SQL?';
$lang['db_compress_question']	= 'Тип архивации?';
$lang['db_insert_question']		= 'Добавить &lsquo;Inserts&rsquo; для данных SQL?';

$lang['db_restore_note']		= 'Опция восстановления возможна для текстовых файлов, архивные файлы удобны для скачивания';

$lang['db_gzip']				= 'gzip';
$lang['db_zip']					= 'zip';
$lang['db_backup']				= 'Бекап';
$lang['db_tables']				= 'Таблицы';
$lang['db_restore']	 			= 'Восстановить';
$lang['db_database']			= 'База данных';
$lang['db_drop']				= 'Удалить';
$lang['db_repair']				= 'Починить';
$lang['db_optimize']			= 'Оптимизировать';

$lang['db_delete_note']			= 'Удалить выбранные файлы: ';
$lang['db_no_backups']			= 'No previous backups were found.';
$lang['db_backup_delete_confirm']	= 'Really delete the following backup files?';
$lang['db_drop_confirm']		= 'Really delete the following database tables?';
$lang['db_drop_attention']		= '<p>Deleting tables from the database will result in loss of data.</p><p><strong>This may make your application non-functional.</strong></p>';

$lang['db_table_name']			= 'Table Name';
$lang['db_records']				= 'Records';
$lang['db_data_size']			= 'Data Size';
$lang['db_index_size']			= 'Index Size';
$lang['db_data_free']			= 'Data Free';
$lang['db_engine']				= 'Engine';
$lang['db_no_tables']			= 'No tables were found for the current database.';

$lang['db_restore_results']		= 'Restore Results';
$lang['db_back_to_tools']		= 'Back to Database Tools';
$lang['db_restore_file']		= 'Restore database from file';
$lang['db_restore_attention']	= '<p>Restoring a database from a backup file will result in some or all of your database being erased before restoring.</p><p><strong>This may result in a loss of data</strong>.</p>';

$lang['db_database_settings']	= 'Database Settings';
$lang['db_hostname']			= 'Hostname';
$lang['db_dbname']				= 'Database Name';
$lang['db_advanced_options']	= 'Advanced Options';
$lang['db_persistant_connect']	= 'Persistant Connection';
$lang['db_display_errors']		= 'Display Database Errors';
$lang['db_enable_caching']		= 'Enable Query Caching';
$lang['db_cache_dir']			= 'Cache Directory';
$lang['db_prefix']				= 'Prefix';

$lang['db_servers']				= 'Servers';
$lang['db_driver']				= 'Driver';
$lang['db_persistant']			= 'Persistant';
$lang['db_debug_on']			= 'Debug On';
$lang['db_strict_mode']			= 'Strict Mode';
$lang['db_running_on_1']		= 'You are currently running on the';
$lang['db_running_on_2']		= 'server.';