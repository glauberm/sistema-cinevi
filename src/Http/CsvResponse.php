<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\Response;

class CsvResponse extends Response
{
    private $data;
    private $filename;

    public function __construct($filename, $data = array(), $status = 200, $headers = array())
    {
        parent::__construct('', $status, $headers);
        $this->filename = $filename.'_'.md5(uniqid(rand(), true)).'.csv';
        $this->encode($data);
        $this->serve();
    }

    private function encode(array $data)
    {
        $handle = fopen('php://temp', 'w+');

        foreach ($data as $row) {
            if ($row === reset($data)) {
                foreach ($row as $lineKey => $lineValue) {
                    $row[$lineKey] = mb_strtoupper($row[$lineKey]);
                }
            }
            foreach ($row as $lineKey => $lineValue) {
                $row[$lineKey] = mb_convert_encoding($row[$lineKey], 'Windows-1252', 'UTF-8');
            }
            fputcsv($handle, $row, ';');
        }
        rewind($handle);

        $this->data = stream_get_contents($handle);

        fclose($handle);
    }

    private function serve()
    {
        $this->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $this->filename));
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', 'text/csv');
        }

        return $this->setContent($this->data);
    }
}
