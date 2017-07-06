<?php

/**
 * Just ads a method to all models to dump a html link to view action of their controllers
 * @author vikas
 * 
 * @property Project $owner
 */
class XLSBehavior extends CActiveRecordBehavior
{
    var $controller;
    var $namefield;
    var $cacheprefix;
    private $SALT = 'NameLinkBehavior';

    public function attach($owner)
    {
        parent::attach ( $owner );
    }

    public function getnamelink($params = [], $linkprops = [])
    {
        list ( $name, $id ) = $this->namelinkprops ();
        $linkparams = [ 
                $this->controller . '/view',
                'id' => $id 
        ];
        if (! empty ( $params ))
            $linkparams = array_merge ( $linkparams, $params );
        
        $model = $this->getOwner ();
        
        if (empty ( $linkprops ['class'] ))
            $linkprops ['class'] = '';
        
        $linkprops ['class'] .= ' nl ' . get_class ( $model );
        
        return CHtml::link ( $name, $linkparams, $linkprops );
    }

    /**
     *
     * @see https://gist.github.com/r-sal/4313500
     * @param unknown $id            
     * @param unknown $type            
     */
    public function getXLSTemplate($outputfile = 'php://output')
    {
        $objPHPExcel = new PHPExcel ();
        $activeSheet = $objPHPExcel->getActiveSheet ();
        $dailychart = Gantt::dataProvider ( $this->owner->id_project );
        $sheet [] = [ 
                $this->owner->id_project . '-' . $this->owner->name 
        ];
        $sheet [] = [ 
                __ ( 'Update' ) 
        ];
        $sheet [] = [ 
                __ ( 'Date: (DD/MM/YY)' ) 
        ];
        $sheet [] = [ 
                __ ( 'Location:' ) 
        ];
        $sheet [] = [ 
                __ ( 'Filled By:' ) 
        ];
        $sheet [] = [ 
                __ ( 'Comments:' ) 
        ];
        $sheet [] = [ 
                __ ( 'Production Tasks' ),
                __ ( 'Unit' ),
                __ ( 'Produced' ) 
        ];
        foreach ( $dailychart ['tmids'] as $id_tm )
        {
            $tm = TaskMaterial::model ()->cacheByPk ( $id_tm );
            if ($tm->isUnitFormula ())
                continue;
            $sheet [] = [ 
                    $tm->id_task . '-' . $tm->name,
                    $tm->material->unit->name 
            ];
        }
        $activeSheet->fromArray ( $sheet );
        // PROJECT NAME
        $activeSheet->getStyle ( "A1:A1" )->applyFromArray ( 
                array (
                        "font" => array (
                                "bold" => true,
                                'size' => 18 
                        ) 
                ) );
        // UPDATE TITLE
        $activeSheet->getStyle ( "A2:A2" )->applyFromArray ( 
                array (
                        "font" => array (
                                'color' => array (
                                        'argb' => '000000FF' 
                                ),
                                "bold" => true,
                                'size' => 16 
                        ) 
                ) );
        // BOLD THE FIRST ROW
        $activeSheet->getStyle ( "A7:C7" )->applyFromArray ( 
                array (
                        "font" => array (
                                'color' => array (
                                        'argb' => '000000FF' 
                                ),
                                "bold" => true 
                        ) 
                ) );
        
        // BOLD THE FIRST COL
        /*
         * $activeSheet->getStyle ( "A2:A" . count($sheet) )->applyFromArray (
         * array (
         * "font" => array (
         * "bold" => true
         * )
         * ) );
         */
        
        $objPHPExcel->getActiveSheet ()->getColumnDimension ( 'A' )->setAutoSize ( true );
        $objPHPExcel->getActiveSheet ()->getColumnDimension ( 'B' )->setWidth ( 20 );
        
        $styleThinBlackBorderOutline = array (
                'borders' => array (
                        'bottom' => array (
                                'style' => PHPExcel_Style_Border::BORDER_THIN 
                        ),
                        'top' => array (
                                'style' => PHPExcel_Style_Border::BORDER_THIN 
                        ),
                        'right' => array (
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM 
                        ),
                        'left' => array (
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM 
                        ) 
                ) 
        );
        $objPHPExcel->getActiveSheet ()->getStyle ( 'A7:C' . count ( $sheet ) )->applyFromArray ( 
                $styleThinBlackBorderOutline );
        
        $objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setSize ( 20 );
        $objPHPExcel->getActiveSheet ()->getRowDimension ( '1' )->setRowHeight ( 30 );
        $objPHPExcel->getActiveSheet ()->getRowDimension ( '2' )->setRowHeight ( 25 );
        
        $highestRow = $objPHPExcel->getActiveSheet ()->getHighestRow ();
        $highestColumn = $objPHPExcel->getActiveSheet ()->getHighestColumn ();
        
        // making sheet locked
        $sheet = $objPHPExcel->getActiveSheet ();
        $sheet->getProtection ()->setPassword ( 'password hare' );
        $sheet->getProtection ()->setSheet ( true );
        // and some cells writable
        $sheet->getStyle ( 'B3:B6' )->getProtection ()->setLocked ( PHPExcel_Style_Protection::PROTECTION_UNPROTECTED );
        $sheet->getStyle ( 'C8:C' . $highestRow )->getProtection ()->setLocked ( 
                PHPExcel_Style_Protection::PROTECTION_UNPROTECTED );
        
        if (! defined ( 'UNIT_TESTING' ))
        {
            header ( 'Content-Type: application/vnd.ms-excel' );
            header ( 'Content-Disposition: attachment;filename="your_name.xls"' );
            header ( 'Cache-Control: max-age=0' );
        }
        $writer = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
        $writer->save ( $outputfile );
    }

    public function ParseUpdateTemplate()
    {
        error_log ( "uploading file" );
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (! isset ( $_FILES ['file'] ['error'] ) || is_array ( $_FILES ['file'] ['error'] ))
        {
            throw new RuntimeException ( 'Invalid parameters.' );
        }
        
        // Check $_FILES['upfile']['error'] value.
        switch ($_FILES ['file'] ['error'])
        {
            case UPLOAD_ERR_OK :
                break;
            case UPLOAD_ERR_NO_FILE :
                throw new RuntimeException ( 'No file sent.' );
            case UPLOAD_ERR_INI_SIZE :
            case UPLOAD_ERR_FORM_SIZE :
                throw new RuntimeException ( 'Exceeded filesize limit.' );
            default :
                throw new RuntimeException ( 'Unknown errors.' );
        }
        
        // You should also check filesize here.
        if ($_FILES ['file'] ['size'] > 10485760)
        {
            throw new RuntimeException ( 'Exceeded filesize limit.' );
        }
        
        $finfo = new finfo ( FILEINFO_MIME_TYPE );
        if (false === $ext = array_search ( $finfo->file ( $_FILES ['file'] ['tmp_name'] ), 
                array (
                        'xls' => 'application/vnd.ms-office' 
                ), true ))
        {
            throw new RuntimeException ( 'Invalid file format.' );
        }        
       
        /////////////////
        $objPHPExcel = PHPExcel_IOFactory::load (  $_FILES ['file'] ['tmp_name'] );        
        // Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet ( 0 );
        $highestRow = $sheet->getHighestRow ();
        $highestColumn = $sheet->getHighestColumn ();
        
        $UpdateData = $sheet->rangeToArray ( 'A1:B6', NULL, TRUE, FALSE );
        error_log(__METHOD__ . ":" . print_r($UpdateData,true));
        
        $mats=[];
        if(!preg_match('/^(?<id_project>\d+)\-.*/', $UpdateData[0][0],$mats))
        {
            throw new RuntimeException ( 'File format does not match the template. E222' );
        }
        $postdata['id_project'] = $mats['id_project'];
        $proj = Controller::$dic->get('Project')->findByPk($postdata['id_project']);
        if(!$proj)
        {
            throw new RuntimeException ( 'Project ID ' . $mats['id_project'] . ' invalid E232' );
        }
        
        if(!preg_match('/^(?<id_filed_by_person>\d+)/', $UpdateData[4][1],$mats))
        {
            throw new RuntimeException ( 'File format does not match the template. E222' );
        }
        $postdata['id_filed_by_person'] = $mats['id_filed_by_person'];        
        
        //create date using 4 digit year
        $datev = DateTime::createFromFormat('d/m/Y', $UpdateData[2][1]);
        //check if it is >= project start date
        $p_start_date = new DateTime($proj->started_date);
        $p_due_date= new DateTime($proj->due_date);
        if($datev< $p_start_date || $datev> $p_due_date)
        {
            error_log(__METHOD__ . ": checking date must be 2 digit years");
            //create date using 2 digit year
            $datev= DateTime::createFromFormat('d/m/y', $UpdateData[2][1]);
            if($datev< $p_start_date || $datev> $p_due_date)
                throw new RuntimeException ( 'Update Date not valid or within range. E251' );
        }        
        
        $postdata['filedAt'] = $datev->format('Y-m-d');
        $postdata['location'] = $UpdateData[3][1];
        $postdata['des'] = $UpdateData[3][1];
        
        $TasksRowData = $sheet->rangeToArray ( 'A8:C' . $highestRow, NULL, TRUE, FALSE );
        error_log(__METHOD__ . ":" . print_r($TasksRowData,true));
        
        foreach($TasksRowData as $ud)
        {
            $mats=[];
            if(!preg_match('/^(?<id_task>\d+)\-.*/', $ud[0],$mats))
            {
                throw new RuntimeException ( 'File format does not match the template. E236' );
            }
            $postdata['task' . $mats['id_task']] =$ud[2];
        }        
        return $postdata;
        
    }
}
