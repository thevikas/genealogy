<?php
/**
 * Implemented the wrapper class for the Linear Regression model
 * This is called from views and other places
 * @author vikasyadav
 *
 */
class MLLinearRegression
{
    // scalling divisor from predictors_1
    var $predictor_1_d = 0;
    // scalling divisor from actual values
    var $predicted_d = 0;
    function scaleset(&$vals, &$divisor)
    {
        //echo "scalelling:\n";
        //print_r ( $vals );
        // find max value
        $mx = max ( $vals );
        // print "max val found:$mx\n";
        // echo "<h2>before</h2><pre>";
        // print_r($vals);
        $vals2 = array_map ( function ($v) use($mx)
        {
            return $v / $mx;
        }, $vals );
        // echo "</pre><h2>After</h2><pre>";
        // print_r($vals2);
        // echo "</pre>";
        // die;
        $divisor = $mx;
        $vals = $vals2;
        //print_r ( $vals );
        //print "end of scalling\n";
    }
    public function learn($predictors_1, $predicted)
    {
        // The divisor for values, to scale every value in the same level

        // The divisor from all attribute values, to scale every value in the same level
        //print "Calling scalling for attributes\n";
        $this->scaleset ( $predictors_1, $this->predictor_1_d );
        //print "Calling scalling for values\n";
        $this->scaleset ( $predicted, $this->predicted_d );

        //print "Divisors: for unit:$this->predictor_1_d, for value:$this->predicted_d<br/>";

        $predictors = array_map ( function ($v)
        {
            return array (
                    $v
            );
        }, $predictors_1 );
        $predicted = array_map ( function ($v)
        {
            return array (
                    $v
            );
        }, $predicted );

        // echo "after scalling:\n";
        // print_r($predictors);
        // print_r($predicted);

        if (count ( $predictors ) < 4)
        {
            echo "<b>Too little (" . count ( $predictors ) . ") data available to make report</b>";
            return;
        }
        // die;
        $regression = new Regression ();
        $regression->setX ( new Matrix ( $predictors ) );
        $regression->setY ( new Matrix ( $predicted ) );
        $regression->exec ();

        $result = $regression->getCoefficients ()->getData ();
        // got the gradient here
        $this->data0 = $result [0] [0];
        $this->data1 = $result [1] [0];
    }
    public function predict($predictors_2)
    {
        $result = array ();
        $predictor_1_d = $this->predictor_1_d;
        // scale set 2 with set 1 divisor
        $predictors_2 = array_map (
                function ($v) use($predictor_1_d)
                {
                    return array (
                            $v,
                            $v / $predictor_1_d
                    );
                }, $predictors_2 );
        //print_r ( $predictors_2 );
        foreach ( $predictors_2 as $vs )
        {
            $v = $vs [1];
            $result [$vs [0]] = round ( ($this->data0 + ($v * $this->data1)) * $this->predicted_d );
        }
        return $result;
    }
}
