
<?php

function MakePagination($CurPage, $NumPages, $FormatString, $CurPageFormatString, $MaxOthers = 3)
{
	$str = '';
	
	$start = max($CurPage - $MaxOthers, 1);
	for ($i = $start; $i <= $NumPages && $i <= $start + ($MaxOthers * 2); $i++)
	{
		if ($i > $start)
			$str .= ' ';
		$str .= sprintf($i == $CurPage ? $CurPageFormatString : $FormatString, $i, $i);
	}
	
	return $str;
}

$page = basename(__FILE__);

$cPage = @$_GET['p'] ?: 1;
$nPages = 12;

echo "<a href='$page?p=1'>&laquo;</a> ";
echo "<a href='$page?p=" . ($cPage - 1) . "'>&lsaquo;</a> ";
echo MakePagination($cPage, $nPages, "<a href='$page?p=%d'>%d</a>", "<strong>%d</strong>");
echo " <a href='$page?p=" . ($cPage + 1) . "'>&rsaquo;</a>";
echo " <a href='$page?p=" . ($nPages - 1) . "'>&raquo;</a>";

?>
