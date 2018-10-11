<?php
namespace App\Libraries\Report;

use App\Libraries\FPDF\Report;

class PayrollReport extends Report{
    
    public $reportAreaWidth;
    public $height;
    public $columnWidth;
    public static $earnings = 0;
    public static $deductions = 0;
    public $total = 0;
    
    public function setEmployeeInfo($jobDetails)
    {
        
        $this->Cell($this->reportAreaWidth,1,"","B",1,"C");
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40,$this->height,"Employee Name: ",0,0,"L");
        $this->SetFont('Arial', '', 12);
        $this->Cell(50,$this->height,$jobDetails->employee->name,0,0,"L");
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40,$this->height,"Department: ",0,0,"L");
        $this->SetFont('Arial', '', 12);
        $this->Cell(50,$this->height,$jobDetails->department->name,0,1,"L");
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40,$this->height,"Designation: ",0,0,"L");
        $this->SetFont('Arial', '', 12);
        $this->Cell(50,$this->height,$jobDetails->designation->title,0,1,"L");
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40,$this->height,"Month & Year: ",0,0,"L");
        $this->SetFont('Arial', '', 12);
        $this->Cell(50,$this->height,"July, 2015",0,1,"L");
    }
    
    public function setPayRollInfo($jobDetails)
    {
        
        $this->SetFont('Arial','B',12);
        $this->Cell($this->columnWidth,$this->height,"Earnings",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,"",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,"Deductions",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,"",1,1,"L");
        $this->SetFont('Arial','',12);
        $templates = json_decode($jobDetails->PaymentGroup->template);
        
        foreach($templates as $t)
        {
            if($t->head_type == "Expense"){
                $this->Cell($this->columnWidth,$this->height,$t->head_name,1,0,"L");
                $this->Cell($this->columnWidth,$this->height,$t->amount.'/-',1,0,"R");
                PayrollReport::$earnings += $t->amount;
            }else{
                $this->Cell($this->columnWidth,$this->height,"",1,0,"L");
                $this->Cell($this->columnWidth,$this->height,"",1,0,"L");
            }
            
             if($t->head_type == "Income"){
                $this->Cell($this->columnWidth,$this->height,$t->head_name,1,0,"L");
                $this->Cell($this->columnWidth,$this->height,$t->amount.'/-',1,1,"L");
                PayrollReport::$deductions += $t->amount;
             }else{
                $this->Cell($this->columnWidth,$this->height,"",1,0,"L");
                $this->Cell($this->columnWidth,$this->height,"",1,1,"L"); 
             }
        }
        
        // Total Earnings
        $this->Cell($this->columnWidth,$this->height,"",1,0,"R");
        $this->Cell($this->columnWidth,$this->height,"",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,"Total Earnings:",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,PayrollReport::$earnings.'/-',1,1,"R");
        
        // Total Deductions
        $this->Cell($this->columnWidth,$this->height,"",1,0,"R");
        $this->Cell($this->columnWidth,$this->height,"",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,"Total Deductions:",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,PayrollReport::$deductions.'/-',1,1,"R");
        
        // Net Total 
        $this->SetFont('Arial','B',12);
        $this->Cell($this->columnWidth,$this->height,"",1,0,"R");
        $this->Cell($this->columnWidth,$this->height,"",1,0,"L");
        $this->Cell($this->columnWidth,$this->height,"Net Total:",1,0,"L");
        $this->total = (PayrollReport::$earnings - PayrollReport::$deductions);
        $this->Cell($this->columnWidth,$this->height,$this->total.'/-',1,1,"R");
        
        $this->Cell($this->reportAreaWidth,$this->height,"In Word: ".ucwords($this->convertDigitToWord($this->total)));
    }
    
    private function convertDigitToWord($number)
    {
        $cleanNumber = str_replace(array('-','_',','),"",$number);
        $numLen = strlen($cleanNumber); 
        $word = '';
        $c = 1;
        if($cleanNumber>=10000000){
            
            $pos = $this->getPos($cleanNumber,10000000);
            $number = $this->getNumber($pos/10000000);
            
            $word .= $number.' Crore ';
            $cleanNumber =  $cleanNumber-$pos;
            $this->convertDigitToWord($cleanNumber);
        }
        if($cleanNumber>=100000 && $cleanNumber < 10000000)
        {
            $pos = $this->getPos($cleanNumber,100000);
            $number = $this->getNumber($pos/100000);
            
            $word .= $number.' Lac ';
            $cleanNumber =  $cleanNumber-$pos;
            $this->convertDigitToWord($cleanNumber);
        }
        if($cleanNumber>=1000 && $cleanNumber < 100000)
        {
            $pos = $this->getPos($cleanNumber,1000);
            $number = $this->getNumber($pos/1000);
            
            $word .= $number.' Thousand ';
            $cleanNumber =  $cleanNumber-$pos;
            
            $this->convertDigitToWord($cleanNumber);
        }
        if($cleanNumber>=100 && $cleanNumber < 1000)
        {
            $pos = $this->getPos($cleanNumber,100);
            $number = $this->getNumber($pos/100);
            $word .= $number.' Hundred ';
            $cleanNumber =  $cleanNumber-$pos;
            $this->convertDigitToWord($cleanNumber);
            
        }
        if($cleanNumber>10 && $cleanNumber < 100)
        {
            $pos = $this->getPos($cleanNumber,10);
            $number = $this->getNumber($pos);
            $word .= $number;
            $cleanNumber =  $cleanNumber-$pos;
            $this->convertDigitToWord($cleanNumber);
        }if($cleanNumber>0 && $cleanNumber < 10){
            
            $pos = $this->getPos($cleanNumber,1);
            $number = $this->getNumber($pos);
            $word .= $number;
            
            $cleanNumber =  $cleanNumber-$pos;
            if($cleanNumber>0)
            $this->convertDigitToWord($cleanNumber);
        }
        
        
        return $word .' BDT only';
    }
    
    private function getPos($cleanNumber,$unit)
    {
        $a = ($cleanNumber/$unit);
        $n = explode(".",$a);
        return $n[0]*$unit;
    }
    
    private function getNumber($number)
    {
        $count = strlen($number);
       
        switch($count)
        {
            case 1:
                return $this->getSignleDigitWord($number);
                break;
                
            case 2:
               
                return $this->getDoubleDigitWord($number);
                break;
                
            
        }
        
    }
    
    private function getSignleDigitWord($number)
    {
        switch($number)
                {
                    case 1:
                        return 'one';
                        break;
                    case 2:
                        return 'two';
                        break; 
                    case 3:
                        return 'three';
                        break;
                    case 4:
                        return 'four';
                        break;
                    case 5:
                        return 'five';
                        break; 
                    case 6:
                        return 'six';
                        break;
                    case 7:
                        return 'seven';
                        break;
                    case 8:
                        return 'eight';
                        break; 
                    case 9:
                        return 'nine';
                        break;
                }
    }
    
    private function getDoubleDigitWord($number)
    {
        $number = $number.'';
         
          
        switch($number[0])
                {
                    case 1:
                        if($number[1] == 0) return 'Ten'; 
                        if(1 && $number[1] == 1) return 'eleven';
                        if(1 && $number[1] == 2) return 'twelve';
                        if(1 && $number[1] == 3) return 'thirteen';
                        if(1 && $number[1] == 4) return 'fourteen';
                        if(1 && $number[1] == 5) return 'fifteen';
                        if(1 && $number[1] == 6) return 'sixteen';
                        if(1 && $number[1] == 7) return 'seventeen';
                        if(1 && $number[1] == 8) return 'eighteen';
                        if(1 && $number[1] == 9) return 'nineteen'; 
                    break;
                    case 2:
                        return 'twenty '.($this->getSignleDigitWord($number[1]));
                        break; 
                    case 3:
                        return 'thirty '.($this->getSignleDigitWord($number[1]));
                        break;
                    case 4:
                        return 'fourty '.($this->getSignleDigitWord($number[1]));
                        break;
                    case 5:
                        
                        return 'fifty '.($this->getSignleDigitWord($number[1]));
                        break; 
                    case 6: 
                        return 'sixty '.($this->getSignleDigitWord($number[1]));
                        break;
                    case 7:
                        return 'seventy '.($this->getSignleDigitWord($number[1]));
                        break;
                    case 8:
                        return 'eighty '.($this->getSignleDigitWord($number[1]));
                        break; 
                    case 9:
                        return 'ninety '.($this->getSignleDigitWord($number[1]));
                        break;
                }
    }
    
}