<?php

/*

 ----------------------------------------------------------------------
GLPI - Gestionnaire libre de parc informatique
 Copyright (C) 2002 by the INDEPNET Development Team.
 http://indepnet.net/   http://glpi.indepnet.org


 ----------------------------------------------------------------------
 LICENSE

This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

    Based on :   The example witch come with :
    Spreadsheet::WriteExcel written by John McNamara, jmcnamara@cpan.org
 ----------------------------------------------------------------------
 Original Author of file:
 Purpose of file:
 ----------------------------------------------------------------------


*/



include ("_relpos.php");

include ($phproot . "/glpi/includes.php");
include ($phproot . "/glpi/dicts/french.php");

$db = new DB;
$query = "select * from monitors";
$result = $db->query($query);
$num_field = $db->num_fields($result);


//set_time_limit(10);

require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";

$fname = tempnam("tmp/", "moniteurs.xls");
$workbook = &new writeexcel_workbook($fname);
$worksheet = &$workbook->addworksheet();

# Set the column width for columns 2 and 3
$worksheet->set_column(1, 2, 20);

# Set the row height for row 2
$worksheet->set_row(2, 30);

# Create a border format
$border1 =& $workbook->addformat();
$border1->set_color('white');
$border1->set_bold();
$border1->set_size(15);
$border1->set_pattern(0x1);
$border1->set_fg_color('green');
$border1->set_border_color('yellow');
$border1->set_top(6);
$border1->set_bottom(6);
$border1->set_left(6);
$border1->set_align('center');
$border1->set_align('vcenter');
$border1->set_merge(); # This is the key feature


/*
# Create another border format. Note you could use copy() here.
$border2 =& $workbook->addformat();
$border2->set_color('white');
$border2->set_bold();
$border2->set_size(15);
$border2->set_pattern(0x1);
$border2->set_fg_color('green');
$border2->set_border_color('yellow');
$border2->set_top(6);
$border2->set_bottom(6);
$border2->set_right(6);
$border2->set_align('center');
$border2->set_align('vcenter');
$border2->set_merge(); # This is the key feature
*/

# Only one cell should contain text, the others should be blank.
$worksheet->write(0, 0, $lang["monitors"][27], $border1);
$worksheet->write(0, 1, $lang["monitors"][5], $border1);
$worksheet->write(0, 2, $lang["monitors"][16],   $border1);
$worksheet->write(0, 3, $lang["monitors"][9],  $border1);
$worksheet->write(0, 4, $lang["monitors"][13],  $border1);
$worksheet->write(0, 5, $lang["monitors"][8], $border1);
$worksheet->write(0, 6, $lang["monitors"][7], $border1);
$worksheet->write(0, 7, $lang["monitors"][12], $border1);
$worksheet->write(0, 8, $lang["monitors"][10], $border1);
$worksheet->write(0, 9, $lang["monitors"][11], $border1);
$worksheet->write(0, 10, $lang["monitors"][15], $border1);
$worksheet->write(0, 11, $lang["monitors"][19], $border1);
$worksheet->write(0, 12, $lang["monitors"][20], $border1);
$worksheet->write(0, 13, $lang["monitors"][24], $border1);
$worksheet->write(0, 14, $lang["monitors"][25], $border1);
$worksheet->write(0, 15, $lang["monitors"][26], $border1);
$y=1;
while($ligne = $db->fetch_array($result))
{
	for($i=0;$i<$num_field;$i++)
	{
		$worksheet->write($y, $i, $ligne[$i]);
	}
	$y++;
}

$workbook->close();

header("Content-Type: application/x-msexcel");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);

?>
