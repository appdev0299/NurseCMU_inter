<?php
require 'database_connection.php';
include_once('TCPDF/tcpdf.php');

$id = $_GET['id'];
$university_id = $_GET['university_id'];
$inv_mst_query = "SELECT T1.id, T1.university, T1.university_id, T1.date_s, T1.date_e, T1.name, T1.details, T1.activity,
                 T2.university_id, T2.department, T2.ranking, T2.mou, T2.signed, T2.expired, T2.country, T2.spec,T2.comments_u, T2.reg_by, T2.dateCreate
                 FROM dateinter T1
                 LEFT JOIN university T2 ON T1.university_id = T2.university_id
                 WHERE T1.id = '" . $id . "'";
$inv_mst_results = mysqli_query($con, $inv_mst_query);
$count = mysqli_num_rows($inv_mst_results);
if ($inv_mst_results === false) {
	echo "ข้อผิดพลาดในคำสั่ง SQL: " . mysqli_error($con);
}


if ($count > 0) {
	$inv_mst_data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC);

	//----- Code for generate pdf
	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	//$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
	$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetDefaultMonospacedFont('thsarabunnew');
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetMargins(PDF_MARGIN_LEFT, '1', PDF_MARGIN_RIGHT);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetAutoPageBreak(TRUE, 10);
	$pdf->SetFont('thsarabunnew', '', 15);
	$pdf->SetMargins(10, 20, 10);
	$pdf->AddPage(); //default A4



	// 
	$content = '';

	$content .= '
	<table>
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td><b>University : </b>' . $inv_mst_data_row['university'] . ' </td>
			<td><b>Department : </b>' . $inv_mst_data_row['department'] . ' </td>
		</tr>
		<tr>
			<td><b>Country : </b>' . $inv_mst_data_row['country'] . ' </td>
			<td><b>QS Ranking : </b>' . $inv_mst_data_row['ranking'] . ' </td>
		</tr>
		<tr>
			<td><b>QS Ranking by Subject : </b>' . $inv_mst_data_row['qs_subject'] . ' </td>
			<td><b>Specialization: </b>' . $inv_mst_data_row['spec'] . ' </td>
		</tr>
		<tr>
			<td><b>Comments : </b>' . $inv_mst_data_row['comments_u'] . ' </td>
			<td><b>MOU/MOA: </b>' . $inv_mst_data_row['mou'] . ' </td>
		</tr>
		<tr>
			<td><b>Date MOU(D/M/Y) : </b>' . (!empty($inv_mst_data_row['signed']) ? date('d M Y', strtotime($inv_mst_data_row['signed'])) : '') . '</td>
			<td><b>Expired: </b>' . (!empty($inv_mst_data_row['expired']) ? date('d M Y', strtotime($inv_mst_data_row['expired'])) : '') . '</td>
		</tr>
		<tr>
			<td></td>
			<td align="right"><b>Update : </b>' . $inv_mst_data_row['dateCreate'] . '</td>
		</tr>
		<tr>
			<td colspan="2"><br><hr></td>
		</tr>
		<tr>
			<td><b>Activity Type : </b>' . $inv_mst_data_row['activity'] . ' </td>
			<td><b>Name : </b>' . $inv_mst_data_row['name'] . ' </td>
		</tr>
		<tr>
			<td><b>Start : </b>' . (!empty($inv_mst_data_row['date_s']) ? date('d M Y', strtotime($inv_mst_data_row['date_s'])) : '') . '</td>
			<td><b>End: </b>' . (!empty($inv_mst_data_row['date_e']) ? date('d M Y', strtotime($inv_mst_data_row['date_e'])) : '') . '</td>
		</tr>
		<tr>
			<td colspan="2"><b>Details : </b>' . $inv_mst_data_row['details'] . ' </td>
		</tr>
		<tr>
			<td colspan="2"><br><hr></td>
		</tr>
	</table>
';




	$pdf->writeHTML($content);

	$file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/";
	date_default_timezone_set('Asia/Bangkok');

	$year = date('Y') + 543;

	$datetime = date('Y');
	$datetime_be = str_replace(date('Y'), $year, $datetime);
	$file_name = "NurseCMU_" . $datetime_be . "-" . $inv_mst_data_row['university_id'] . ".pdf";
	ob_end_clean();

	if ($_GET['ACTION'] == 'VIEW') {
		$pdf->Output($file_name, 'I'); // I means Inline view
	} else if ($_GET['ACTION'] == 'DOWNLOAD') {
		$pdf->Output($file_name, 'D'); // D means download
	} else if ($_GET['ACTION'] == 'UPLOAD') {
		$pdf->Output($file_location . $file_name, 'F'); // F means upload PDF file on some folder
		echo "Upload successfully!!";
	}

	//----- End Code for generate pdf

} else {
	echo 'Record not found for PDF.';
}
