<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\Response;

class CsvResponse extends Response
{
    protected $data;
    protected $filename;

    public function __construct($filename, $data = array(), $status = 200, $headers = array())
    {
        parent::__construct('', $status, $headers);
        $this->filename = $filename.'_'.md5(uniqid(rand(), true)).'.csv';
        $this->setData($data);
    }

    public function setData(array $data)
    {
        $output = fopen('php://temp', 'r+');

        foreach ($data as $row) {
            if ($row === reset($data)) {
                foreach ($row as $lineKey => $lineValue) {
                    $row[$lineKey] = mb_strtoupper($row[$lineKey]);
                }
            }

            foreach ($row as $lineKey => $lineValue) {
                if($lineValue instanceof \DateTime) {
                    $row[$lineKey] = $lineValue->format('d/m/Y');
                }
                else if(is_array($lineValue)) {
                    $row[$lineKey] = implode(', ',$lineValue);
                } else if(is_bool($lineValue)) {
                    if($lineValue === true) {
                        $row[$lineKey] = 'Sim';
                    } else {
                        $row[$lineKey] = 'Não';
                    }
                } else {
                    $row[$lineKey] = trim(strval($lineValue));
                }
                $row[$lineKey] = mb_convert_encoding($row[$lineKey], 'Windows-1252', 'UTF-8');
            }
            fputcsv($output, $row, ';');
        }
        rewind($output);

        $this->data = '';

        while ($line = fgets($output)) {
            $this->data .= $line;
        }
        $this->data .= fgets($output);

        fclose($output);

        return $this->update();
    }

    protected function update()
    {
        $this->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $this->filename));
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', 'text/csv');
        }

        return $this->setContent($this->data);
    }
}
