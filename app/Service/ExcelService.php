<?php

namespace App\Service;

use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\StringHelper;

class ExcelService extends Controller
{
    private $title;
    private $subtitle;
    private $information;
    private $spreadSheet;
    private $sheet;
    private $filename;
    private $cols;
    private $headers;
    private $activeRow;
    private $activeCol;
    private $styling;

    public function __construct()
    {
        $this->spreadSheet = new Spreadsheet;
        $this->sheet = $this->spreadSheet->getActiveSheet();
        $this->activeRow = 1;
        $this->activeCol = 0;
        foreach(range('A','ZZZ') as $i) $this->cols[] = $i;

        $this->styling = (object) [];
        $this->styling->border = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $this->styling->bold = [
            'font' => [
                'bold' => true,
            ]
        ];
        $this->styling->alignCenter = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
    }

    public function setTitle($title)
    {
        $this->title = $title;

        $this->sheet->setCellValue('A1', $title);
        $this->sheet->getStyle('A1')->applyFromArray($this->styling->bold);
        $this->sheet->getStyle('A1')->applyFromArray($this->styling->alignCenter);

        $this->activeRow += 2;

        return $this;
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        $this->sheet->setCellValue('A2', $subtitle);
        $this->sheet->getStyle('A2')->applyFromArray($this->styling->bold);
        $this->sheet->getStyle('A2')->applyFromArray($this->styling->alignCenter);

        $this->activeRow += 1;

        return $this;
    }

    public function setInformation($data)
    {
        $this->information = $data;

        foreach($data as $key => $value) {
            $this->sheet->setCellValue('A'.$this->activeRow,$key);
            $this->sheet->setCellValue('B'.$this->activeRow,$value);
            $this->activeRow++;
        }

        $this->activeRow += 1;

        return $this;
    }
    
    public function setHeader($headers)
    {
        foreach($headers as $header) {
            if(!is_object($header)) $header = (object) $header;
            $this->sheet->setCellValue($this->cols[$this->activeCol].$this->activeRow, $header->Label);
            $this->sheet->getStyle($this->cols[$this->activeCol].$this->activeRow)->applyFromArray($this->styling->bold);
            $this->sheet->getStyle($this->cols[$this->activeCol].$this->activeRow)->applyFromArray($this->styling->alignCenter);
            $this->sheet->getStyle($this->cols[$this->activeCol].$this->activeRow)->applyFromArray($this->styling->border);
            $this->activeCol++;
        }

        $this->headers = $headers;
        $this->activeRow++;
        $this->activeCol = 0;

        return $this;
    }

    public function setData($data)
    {
        foreach($data as $row) {
            if(!is_object($row)) $row = (object) $row;
            foreach($this->headers as $header) {
                if(!is_object($header)) $header = (object) $header;
                $this->sheet->setCellValue($this->cols[$this->activeCol].$this->activeRow, $row->{$header->Field});
                $this->sheet->getStyle($this->cols[$this->activeCol].$this->activeRow)->applyFromArray($this->styling->border);
                $this->activeCol++;
            }
            $this->activeRow++;
            $this->activeCol = 0;
        }

        return $this;
    }

    public function filename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function download()
    {
        if($this->title) $this->sheet->mergeCells('A1:'.$this->cols[count($this->headers) - 1].'1');
        if($this->subtitle) $this->sheet->mergeCells('A2:'.$this->cols[count($this->headers) - 1].'2');
        
        for($i = 0; $i < count($this->headers); $i++) $this->sheet->getColumnDimension($this->cols[$i])->setAutoSize(true);
        
        $this->sheet->getPageSetup()->setFitToWidth(1);    
        $this->sheet->getPageSetup()->setFitToHeight(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$this->filename.'.xlsx"');
		header('Cache-Control: max-age=1');
        $writer = new Xlsx($this->spreadSheet);
        return $writer->save('php://output');
    }
}