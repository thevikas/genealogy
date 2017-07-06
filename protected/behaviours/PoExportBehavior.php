<?php
/**
 * CRAP on 27Sep14 is 156
 * @author vikasyadav
 * @property array|string $fieldlist Fields list
 */
class PoExportBehavior extends CActiveRecordBehavior
{
    /**
     *
     * @var CActiveRecord
     */
    private $owner;

    public function attach($owner)
    {
        parent::attach ( $owner );
        $this->owner = $owner;
    }

    public function getpofiledata($ids = [], $starting_page = 1, $first_lang = 'en', $second_lang = 'es')
    {
        error_reporting ( E_ALL );
        ini_set ( 'display_error', 'on' );
        $podata = '';
        $pkfield = $this->owner->tableSchema->primaryKey;
        $crit = [ ];
        if (! empty ( $ids ))
        {
            $ids_in = implode ( ',', $ids );
            $crit = [ 
                    'condition' => "t.$pkfield in ($ids_in)" 
            ];
        }
        /* $tagProvider CActiveDataProvider */
        $tagProvider = $this->owner->multilang ()->search ( new CDbCriteria ( $crit ) );
        $tagProvider->setPagination ( [ 
                'pageSize' => 500,
                'currentPage' => $starting_page 
        ] );
        $mldata = $this->owner->behaviors ();
        $attrs = $mldata ['ml'] ['localizedAttributes'];
        // $count = $dataProvider->totalItemCount();
        $translatedLanguages = Yii::app ()->params ['translatedLanguages'];
        foreach ( $tagProvider->getData () as $record )
        {
            foreach ( $attrs as $field )
            {
                $refstr = '#: ' . get_class ( $record ) . ".$field:" . $record->$pkfield;
                foreach ( $translatedLanguages as $code => $lang )
                {
                    if ($code == $first_lang)
                    {
                        $fieldlang = $field;
                        if (! empty ( $record->$fieldlang ))
                            $msgid = "msgid \"" . addslashes ( $record->$fieldlang ) . "\"";
                    }
                    else if ($code == $second_lang)
                    {
                        $fieldlang = $field . '_' . $code;
                        $msgstr = "msgstr \"" . addslashes ( $record->$fieldlang ) . "\"";
                    }
                }
                if (! empty ( $msgid ))
                    $podata .= "$refstr\n$msgid\n$msgstr\n\n";
                $msgid = $msgstr = '';
            }
        }
        return $podata;
    }
}
