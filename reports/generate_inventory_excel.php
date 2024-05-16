<?php
require_once ('./vendor/autoload.php');
include (__DIR__ . '/../utils/db/connector.php');
include (__DIR__ . '/../utils/models/ingredients-facade.php');
include ('../utils/models/user-facade.php');
include ('../utils/models/product-facade.php');
include ('../utils/models/inventory-facade.php');
include ('../utils/models/order-facade.php');
include ('../utils/models/loss_and_damage-facade.php');
include ('../utils/models/supplier-facade.php');
include ('../utils/models/inventorycount-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$active_id = $_GET['active_type'] ?? null;
$inventory = new InventoryFacade();
$orders = new OrderFacade();
$loss_and_damage = new Loss_and_damage_facade();
function isActive($value)
{
    return $value === 1;
}
switch ($active_id) {
    case 'tbl_products':
        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Product');
        $sheet->setCellValue('C1', 'Barcode');
        $sheet->setCellValue('D1', 'Qty in Store');
        $sheet->setCellValue('E1', 'Amount Before Tax');
        $sheet->setCellValue('F1', 'Amount After Tax');
        $sheet->setCellValue('G1', 'Is Paid');

        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        $items = $inventory->get_allInventories();

        $counter = 1;

        foreach ($items as $item) {
            $isPaid = $item['isPaid'] === 1 ? "YES" : "NO";
            $sheet->setCellValue('A' . ($counter + 1), $counter);
            $sheet->setCellValue('B' . ($counter + 1), $item['prod_desc']);
            $sheet->setCellValue('C' . ($counter + 1), $item['barcode']);
            $sheet->setCellValue('D' . ($counter + 1), $item['stock']);
            $sheet->setCellValue('E' . ($counter + 1), number_format($item['amount_beforeTax'], 2));
            $sheet->setCellValue('F' . ($counter + 1), number_format($item['amount_afterTax'], 2));
            $sheet->setCellValue('G' . ($counter + 1), $isPaid);

            $sheet->getStyle('A' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('G' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $counter++;
        }

        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $range = 'A1:' . $lastColumn . $lastRow;
        $style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($style);

        break;
    case 'tbl_orders':
        $items = $orders->get_allPurchaseOrders();

        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'PO#');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Date Purchased');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Is Paid');

        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
        ];
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        $counter = 1;

        foreach ($items as $item) {
            $total = '₱' . number_format($item['totalPrice'], 2);
            $originalDate = $item['date_purchased'];
            $date_purchased = date("M d, Y", strtotime($originalDate));

            $isPaid = $item['isPaid'] === 1 ? "YES" : "NO";
            $sheet->setCellValue('A' . ($counter + 1), $counter);
            $sheet->setCellValue('B' . ($counter + 1), $item['po_number']);
            $sheet->setCellValue('C' . ($counter + 1), $item['supplier']);
            $sheet->setCellValue('D' . ($counter + 1), $date_purchased);
            $sheet->setCellValue('E' . ($counter + 1), $total);
            $sheet->setCellValue('F' . ($counter + 1), $isPaid);

            $sheet->getStyle('A' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('E' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('F' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $counter++;
        }

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $range = 'A1:' . $lastColumn . $lastRow;
        $style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($style);
        break;
    case 'tbl_all_lostanddamages':
        $items = $loss_and_damage->get_all_lostanddamageinfo();
        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Reference No.');
        $sheet->setCellValue('C1', 'Date of Transaction');
        $sheet->setCellValue('D1', 'Reason');
        $sheet->setCellValue('E1', 'Total Qty');
        $sheet->setCellValue('F1', 'Total Cost');
        $sheet->setCellValue('G1', 'Overall Cost');
        $sheet->setCellValue('H1', 'Note');


        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        $counter = 1;

        foreach ($items as $item) {
            $totalCost = '₱ ' . number_format($item['total_cost'], 2);
            $overallCost = '₱ ' . number_format($item['over_all_total_cost'], 2);
            $originalDate = $item['date_transact'];
            $date_transact = date("M d, Y", strtotime($originalDate));

            $sheet->setCellValue('A' . ($counter + 1), $counter);
            $sheet->setCellValue('B' . ($counter + 1), $item['reference_no']);
            $sheet->setCellValue('C' . ($counter + 1), $date_transact);
            $sheet->setCellValue('D' . ($counter + 1), $item['reason']);
            $sheet->setCellValue('E' . ($counter + 1), $item['total_qty']);
            $sheet->setCellValue('F' . ($counter + 1), $totalCost);
            $sheet->setCellValue('G' . ($counter + 1), $overallCost);
            $sheet->setCellValue('H' . ($counter + 1), $item['note']);

            $sheet->getStyle('A' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('G' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('H' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $counter++;
        }

        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $range = 'A1:' . $lastColumn . $lastRow;
        $style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($style);
        break;
    case 'tbl_expiredProducts':
        $items = $inventory->get_realtime_notifications();
        $data = $items['products'];
        $notifications = $items['notifications'];
        $firstNotif_isActive = isActive($notifications[0]['is_active']);//30
        $secondNotif_isActive = isActive($notifications[1]['is_active']);//15
        $thirdNotif_isActive = isActive($notifications[2]['is_active']);//5
        $fourthNotif_isActive = isActive($notifications[3]['is_active']);//0
        $totalExpired = 0;
        $temp = false;
        $verifier = false;

        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Product');
        $sheet->setCellValue('C1', 'Barcode');
        $sheet->setCellValue('D1', 'Expiration Date');
        $sheet->setCellValue('E1', 'Days Remaining');

        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
        $counter = 1;

        foreach ($data as $item) {
            $days_remaining = $item['days_remaining'];
            $originalDate = $item['date_expired'];
            $date_expired = date("M d, Y", strtotime($originalDate));
            if ($firstNotif_isActive && $days_remaining <= 30 && $days_remaining >= 16) {
                $temp = true;
                $verifier = true;
            } else if ($secondNotif_isActive && $days_remaining <= 15 && $days_remaining >= 6) {
                $temp = true;
                $verifier = true;
            } else if ($days_remaining <= 5 && $days_remaining >= 1) {
                $temp = true;
                $verifier=true;
            }
            else if ($fourthNotif_isActive && $days_remaining === 0) {
                $temp = true;
                $verifier=true;
            }
            else{
                $temp = false;
            }

            if ($temp) {
                $sheet->setCellValue('A' . ($counter + 1), $counter);
                $sheet->setCellValue('B' . ($counter + 1), $item['prod_desc']);
                $sheet->setCellValue('C' . ($counter + 1), $item['barcode']);
                $sheet->setCellValue('D' . ($counter + 1), $date_expired);
                $sheet->setCellValue('E' . ($counter + 1), $days_remaining);
    
                $sheet->getStyle('A' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . ($counter + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $counter++;
            }
        }

        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $range = 'A1:' . $lastColumn . $lastRow;
        $style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($style);
        break;
    default:
        break;
}


$filename = str_replace("tbl_", "", $active_id);
$writer = new Xlsx($spreadsheet);
$writer->save($filename . '.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');