<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFunction14ToCollectionReportsfunc extends Migration
{
    public function up()
    {
//        \Illuminate\Support\Facades\DB::statement("
//DELIMITER $$
//DROP FUNCTION IF EXISTS collectionReportFunc;
//
//CREATE FUNCTION collectionReportFunc(pro DATE, inv DATE, ors DATE, types INT) RETURNS TEXT DETERMINISTIC
//BEGIN
//
// DECLARE ans_ym 	TEXT DEFAULT '';
// DECLARE ans_y 	TEXT DEFAULT '';
// DECLARE ans_m 	TEXT DEFAULT '';
// DECLARE pro_month int DEFAULT MONTH(pro);
// DECLARE pro_year  int DEFAULT Year(pro);
// DECLARE inv_month int DEFAULT MONTH(inv);
// DECLARE inv_year  int DEFAULT Year(inv);
// DECLARE ors_month int DEFAULT MONTH(ors);
// DECLARE ors_year  int DEFAULT Year(ors);
// DECLARE ors_date  date DEFAULT CONCAT(ors_year,'-', ors_month, '-31');
// DECLARE now_month int DEFAULT MONTH(NOW());
// DECLARE now_year  int DEFAULT Year(NOW());
// DECLARE now_date  date DEFAULT CONCAT(now_year,'-', now_month, '-31');
//
// IF (inv IS NULL) THEN
//
//	while (pro <= now_date) do
//		SET pro_month = MONTH(pro);
//		SET pro_year  = Year(pro);
//		SET ans_ym 	  = CONCAT(ans_ym, '&quot;',pro_month, '-', pro_year ,'&quot;,' );
//		SET ans_y 	  = CONCAT(ans_y, '&quot;',pro_year ,'&quot;,' );
//		SET ans_m 	  = CONCAT(ans_m, '&quot;',pro_month ,'&quot;,' );
//
//		SET pro = DATE_ADD(pro, INTERVAL 1 MONTH);
//	END while;
//
// ELSEIF (ors IS NULL) THEN
//
// 	while (pro <= now_date) do
//		SET pro_month = MONTH(pro);
//		SET pro_year  = Year(pro);
//		SET ans_ym    = CONCAT(ans_ym, '&quot;', pro_month, '-', pro_year ,'&quot;,' );
//		SET ans_y 	  = CONCAT(ans_y, '&quot;',pro_year ,'&quot;,' );
//		SET ans_m 	  = CONCAT(ans_m, '&quot;',pro_month ,'&quot;,' );
//
//		SET pro = DATE_ADD(pro, INTERVAL 1 MONTH);
//	END while;
//
// ELSE
//
// 	while (pro <= ors_date) do
//		SET pro_month = MONTH(pro);
//		SET pro_year  = Year(pro);
//		SET ans_ym    = CONCAT(ans_ym, '&quot;', pro_month, '-', pro_year ,'&quot;,' );
//		SET ans_y 	  = CONCAT(ans_y, '&quot;',pro_year ,'&quot;,' );
//		SET ans_m 	  = CONCAT(ans_m, '&quot;',pro_month ,'&quot;,' );
//
//		SET pro = DATE_ADD(pro, INTERVAL 1 MONTH);
//	END while;
//
// END if;
//
// if types = 1 then
//	RETURN CONCAT( '[', SUBSTRING(ans_ym, 1, CHAR_LENGTH(ans_ym) - 1), ']' );
//	elseif types = 2 then
//	RETURN CONCAT( '[', SUBSTRING(ans_y, 1, CHAR_LENGTH(ans_y) - 1), ']' );
//	elseif types = 3 then
//	RETURN CONCAT( '[', SUBSTRING(ans_m, 1, CHAR_LENGTH(ans_m) - 1), ']' );
//	END if;
//
//END $$
//DELIMITER ;
//            ");

        $sql = "
DROP FUNCTION IF EXISTS collectionReportFunc;

CREATE FUNCTION collectionReportFunc(pro DATE, inv DATE, ors DATE, types INT) RETURNS TEXT DETERMINISTIC
BEGIN

 DECLARE ans_ym 	TEXT DEFAULT '';
 DECLARE ans_y 	TEXT DEFAULT '';
 DECLARE ans_m 	TEXT DEFAULT '';
 DECLARE test 	TEXT DEFAULT '';
 DECLARE pro_month int DEFAULT MONTH(pro);
 DECLARE pro_year  int DEFAULT Year(pro);
 DECLARE inv_month int DEFAULT MONTH(inv);
 DECLARE inv_year  int DEFAULT Year(inv);
 DECLARE ors_month int DEFAULT MONTH(ors);
 DECLARE ors_year  int DEFAULT Year(ors);
 DECLARE ors_date  date DEFAULT CONCAT(ors_year,'-', ors_month, '-31');
 DECLARE now_month int DEFAULT MONTH(NOW());
 DECLARE now_year  int DEFAULT Year(NOW());
 DECLARE now_date  date DEFAULT CONCAT(now_year,'-', now_month, '-31');

 IF (inv IS NULL) THEN

	while (pro <= now_date) do
		SET pro_month = MONTH(pro);
		SET pro_year  = Year(pro);
		SET ans_ym 	  = CONCAT(ans_ym, '&quot;',pro_month, '-', pro_year ,'&quot;,' );
		SET ans_y 	  = CONCAT(ans_y, '&quot;',pro_year ,'&quot;,' );
		SET ans_m 	  = CONCAT(ans_m, '&quot;',pro_month ,'&quot;,' );

		SET pro = DATE_ADD(pro, INTERVAL 1 MONTH);
	END while;

 ELSEIF (ors IS NULL) THEN

 	while (pro <= now_date) do
		SET pro_month = MONTH(pro);
		SET pro_year  = Year(pro);
		SET ans_ym    = CONCAT(ans_ym, '&quot;', pro_month, '-', pro_year ,'&quot;,' );
		SET ans_y 	  = CONCAT(ans_y, '&quot;',pro_year ,'&quot;,' );
		SET ans_m 	  = CONCAT(ans_m, '&quot;',pro_month ,'&quot;,' );

		SET pro = DATE_ADD(pro, INTERVAL 1 MONTH);
	END while;

 ELSE

 	while (pro <= ors_date) do
		SET pro_month = MONTH(pro);
		SET pro_year  = Year(pro);
		SET ans_ym    = CONCAT(ans_ym, '&quot;', pro_month, '-', pro_year ,'&quot;,' );
		SET ans_y 	  = CONCAT(ans_y, '&quot;',pro_year ,'&quot;,' );
		SET ans_m 	  = CONCAT(ans_m, '&quot;',pro_month ,'&quot;,' );

		SET pro = DATE_ADD(pro, INTERVAL 1 MONTH);
	END while;

 END if;

 if types = 1 then
	RETURN CONCAT( '[', SUBSTRING(ans_ym, 1, CHAR_LENGTH(ans_ym) - 1), ']' );
	if types = 2 then
	RETURN CONCAT( '[', SUBSTRING(ans_y, 1, CHAR_LENGTH(ans_y) - 1), ']' );
	if types = 3 then
	RETURN CONCAT( '[', SUBSTRING(ans_m, 1, CHAR_LENGTH(ans_m) - 1), ']' );
	END if;

END
";

        DB::raw($sql);
//        DB::connection()->getPdo()->exec($sql);
    }

    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS collectionReportFunc;');
    }
}
