<?php

class Template
{
    private $template;

    public function __construct()
    {
        $this->template = '';
    }

    public function setHeader($css, $title=null,$scripts=null,$js_tag=null)
    {
        $this->template .= '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>' . $title . '</title>
    ';

            foreach ($css as $href) {
                $this->template .= '
                <link href="' . $href . '" rel="stylesheet">';
            }
            //---  lib ---------
            if (isset($scripts)) {
                foreach ($scripts as $src) {
                    $this->template .= '
                    <script src="' . $src . '"></script>';
                }
            }
            //----- js ------------
            if (isset($js_tag)) {
                $this->template .= $js_tag;
            }
            
            
            //-----  end head -----
            $this->template .= '
                </head>
            ';
    }

    public function setContent($content)
    {
        $this->template .= '
    <body>
        ';
        $this->template .= $content;
    }

    public function setFooter ($scripts=null, $jsInit=null)
    {
        $this->template .= '
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->';
        if (isset($scripts)) {
            foreach ($scripts as $src) {
                $this->template .= '
                <script src="' . $src . '"></script>';
            }
        }

        
        if (isset($jsInit)) {
            $this->template .= '
                <script>';
            $this->template .= $jsInit;

            $this->template .= '
            </script>';
        }

        $this->template .= '

    </body>
</html>';
    }

    public function render()
    {
        echo $this->template;
    }
}