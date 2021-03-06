<?php
	// Подключаем модуль
	require_once "../excel_mysql.php";

	// Соединение с базой MySQL
	$connection = new mysqli("localhost", "user", "pass", "excel_mysql_base");
	// Выбираем кодировку UTF-8
	$connection->set_charset("utf8");

	// Создаем экземпляр класса excel_mysql
	$excel_mysql_import_export = new Excel_mysql($connection, "./example.xlsx");

	// Примеры без дополнительных настроек

	// Экспортируем таблицу MySQL в Excel
	echo $excel_mysql_import_export->mysql_to_excel("excel_mysql_data", "Экспорт") ? "OK\n" : "FAIL\n";

	// Перебираем все листы Excel и преобразуем в таблицу MySQL
	echo $excel_mysql_import_export->excel_to_mysql_iterate(array("excel_mysql_iterate")) ? "OK\n" : "FAIL\n";

	// Преобразуем первый лист Excel в таблицу MySQL
	echo $excel_mysql_import_export->excel_to_mysql_by_index("excel_mysql_by_index") ? "OK\n" : "FAIL\n";

	// Примеры с дополнительными настройками

	// Указываем названия столбцов в таблице MySQL
	echo $excel_mysql_import_export->excel_to_mysql_by_index("excel_mysql_by_index_with_option_1", 0, array("id", "first_name", "last_name", "email", "pay")) ? "OK\n" : "FAIL\n";

	// Указываем названия столбцов в таблице MySQL и функцию изменения значения для конкретного столбца (например для преобразования дат из Excel в MySQL)
	echo $excel_mysql_import_export->excel_to_mysql_by_index("excel_mysql_by_index_with_option_2", 0, array("id", "first_name", "last_name", "email", "pay"), false, array("pay" => function ($value) { return $value * 2; })) ? "OK\n" : "FAIL\n";

	// Экспортируем таблицу MySQL в Excel
	echo $excel_mysql_import_export->mysql_to_excel("excel_mysql_by_index_with_option_2", "Экспорт") ? "OK\n" : "FAIL\n";

	// Указываем названия столбцов в таблице MySQL и уникальный столбец для обновления таблицы
	echo $excel_mysql_import_export->excel_to_mysql_by_index("excel_mysql_by_index_with_option_1", 0, array("id", "first_name", "last_name", "email", "pay"), 1) ? "OK\n" : "FAIL\n";

	// Указываем названия столбцов в таблице MySQL, их типы и ключевое поле
	echo $excel_mysql_import_export->excel_to_mysql_by_index("excel_mysql_by_index_with_option_3", 0, array("id", "first_name", "last_name", "email", "pay"), false, false, false, array("INT(11) NOT NULL AUTO_INCREMENT", "VARCHAR(50) NOT NULL", "VARCHAR(50) NOT NULL", "VARCHAR(100) NOT NULL", "FLOAT(10,2) NOT NULL"), array("PRIMARY KEY" => "id")) ? "OK\n" : "FAIL\n";