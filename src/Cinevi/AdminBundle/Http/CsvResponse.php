<?php

namespace Cinevi\AdminBundle\Http;

use Symfony\Component\HttpFoundation\Response;

class CsvResponse extends Response
{
    protected $data;
    protected $filename;

    public function __construct($filename = 'tabela', $data = array(), $status = 200, $headers = array())
    {
        parent::__construct('', $status, $headers);
        $this->setData($data);
        $this->filename = $filename.'.csv';
    }

    public function setData(array $data)
    {
        $output = fopen('php://temp', 'r+');

        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);

        $this->data = '';

        while ($line = fgets($output)) {
            $this->data .= $line;
        }
        $this->data .= fgets($output);

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
