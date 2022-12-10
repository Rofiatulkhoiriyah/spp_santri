<?php

namespace App\Service;

use App\Http\Controllers\Controller;
use PDF;

class PdfService extends Controller
{
    private $filename;
    private $information = [];
    private $title;
    private $tableHeader;
    private $data;

    public function setTitle($title) 
    { 
        $this->title = $title;
        return $this;
    }

    public function setInformation($data)
    {
        $this->information = $data;
        return $this;
    }

    public function setHeader($header)
    {
        $this->tableHeader = $header;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function filename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function download($template = null)
    {
        if(!$template) $template = 'Templates.PdfReport';
        $pdf = PDF::loadView($template,['title' => $this->title, 'information' => $this->information, 'tableHeader' => $this->tableHeader, 'data' => $this->data]);

        return $pdf->download($this->filename . '.pdf');
    }
}