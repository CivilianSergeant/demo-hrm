<?php
/**
 * Description of TabulationSheet2
 *
 * @author Himel
 */
require_once APPPATH.'libraries/FPDF/FPDF.php';
class TabulationSheet2 extends FPDF{
    protected $angle;
    private $data;
    private $date;

    public function Rotate($angle, $x=-1, $y=-1) {

        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;

            $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }
    
    public function setHeaderContent($data) {
        $this->data = $data;
    }
    public function Header() {
       
        $this->SetFont('Arial',"b",15);
        $this->Cell(320,15,$this->data['school_info'][0]['school_name'],0,1,"C");
        $this->SetFontSize(10);
        $this->SetX((320-50)/1.9);
        $this->Cell(50,10,"Tabulation Sheet",1,1,"C");
        $this->Cell(10,2," ",0,1,"C");
        $this->Cell(25,10,"Session :",0,0,"R");
        $this->Cell(25,10,$this->data['classInfo']['session'],0,0,"L");
        $this->Cell(25,10,"Class :",0,0,"R");
        $this->Cell(25,10,ucfirst($this->data['classInfo']['class_name']),0,0,"L");
        $this->Cell(25,10,"Group :",0,0,"R");
        $this->Cell(25,10,ucfirst($this->data['classInfo']['group_name']),0,0,"L");
        
        $this->Cell(25,10,"Section :",0,0,"R");
        $this->Cell(25,10,ucfirst($this->data['classInfo']['section_name']),0,0,"L");
        $this->Cell(25,10,"Shift :",0,0,"R");
        $this->Cell(25,10,ucfirst($this->data['classInfo']['shift_name']),0,0,"L");
        $this->Cell(25,10,"Term :",0,0,"R");
        
        $this->Cell(25,10,ucfirst($this->data['classInfo']['term_name']),0,1,"L");
        $this->Cell(10,2," ",0,1,"C");
        $this->SetY(80);
        $this->Rotate(90);
        
        
        $cw = 6;
        $subjectWidth = 32;
        $substract = 2;
        $totalX = 70;$nW=40;
        if(strtolower($this->data['classInfo']['class_name']) == 'ten')
        {
            if($this->data['classInfo']['group_name'] != 'science')
                $totalX = 183;
            else
                $totalX = 195;
            $termW = 10;
            $X = 57;$Y=80;
        
        }else if(strtolower($this->data['classInfo']['class_name']) == 'nine'){
            $totalX = 232.75;
            $termW = 8;
            $cw = 4.75;
            $X = 57;$Y=80;
            $this->SetFontSize(8);
        }else if(strtolower($this->data['classInfo']['class_name']) == 'eight'){
            $totalX = 294;
            $termW = 8;
            $cw = 5.15;
            $X = 57;$Y=80;
            $this->SetFontSize(8);
        }else if(strtolower($this->data['classInfo']['class_name']) == 'seven'){
            $totalX = 266.65;
            $termW = 8;
            $cw = 4.75;
            $X = 53;$Y=80;$nW=36;
            $this->SetFontSize(9);
        }else if(strtolower($this->data['classInfo']['class_name']) == 'six'){
            $totalX = 270.95;
            $termW = 8;
            $cw = 4.45;
            $X = 53;$Y=80;$nW=36;
            $this->SetFontSize(9);
        }
        //$this->Cell($termW,30,"Term",1,0,"C");
        
        $this->Cell(30,7,"Roll No",1,0,"C");
        $this->Rotate(0);
        $this->SetXY(17,50);
        $this->Cell($nW,30,"Name",1,0,"C");
        
        
        foreach($this->data['subjects'] as $subject)
        {
            
            $subjectWidth = (count($subject['mark_type']) * $cw);
            $this->Cell($subjectWidth+($cw * 2),10, str_replace(array(" ","/",""), "\n", str_replace(array("& "),"",trim($subject['subject_name']))),1,0,"C");
        }
        
        
        $startY = 80;
        
        $this->SetXY($totalX+($subjectWidth*7),$startY);
        $this->Rotate(90);
        $this->Cell(30,$cw+1,"Total",1,1,"C");
        $this->SetXY($totalX+($subjectWidth*7),$startY +=$cw+1);
        $this->Cell(30,$cw,"Pass/Fail",1,1,"C");
        $this->SetXY($totalX+($subjectWidth*7),$startY +=$cw);
        $this->Cell(30,$cw,"In Sec",1,1,"C");
        $this->SetXY($totalX+($subjectWidth*7),$startY +=$cw);
        $this->Cell(30,$cw,"In Class",1,1,"C");
        $i=0;
        
        foreach($this->data['subjects'] as $subject)
        {   $w = 0;
            if(strtolower($this->data['classInfo']['class_name']) == 'ten')
            {
                if(strtolower($this->data['classInfo']['group_name'] == 'science'))
                    $w = $this->class_ten_s($subject,$i);
                else
                    $w = $this->class_ten_b($subject,$i);    
            }elseif(strtolower($this->data['classInfo']['class_name']) == 'nine'){
                if(strtolower($this->data['classInfo']['group_name'] == 'science'))
                    $w = $this->class_nine_s($subject,$i);
                else
                    $w = $this->class_nine_b($subject,$i);
            }elseif(strtolower($this->data['classInfo']['class_name']) == "eight"){
                $w = $this->class_eight($subject,$i);
            }elseif(strtolower($this->data['classInfo']['class_name']) == "seven"){
                $w = $this->class_seven($subject,$i);
            }elseif(strtolower($this->data['classInfo']['class_name']) == "six"){
                $w = $this->class_six($subject,$i);
            }
            $this->SetFontSize(8);
            if($i == 0)
                $this->mark_types($subject['mark_type'],0,$X,$Y,$cw);
            else  
                $this->mark_types($subject['mark_type'],($subjectWidth+$w)*$i,$X,$Y,$cw);
            $i++;
        }
        $this->SetY(80);
        
    }
    
    public function mark_types($mark_types,$size,$X,$Y,$i)
    { 
        $incr = $i;
        $startY=$Y;
        $initX = $X;
        $this->SetXY($initX+$size,$Y);
        
        
        $this->Rotate(90);
 
        
        foreach($mark_types as $mk => $mark_type)
        {
            
            $startY = $startY + $incr;
            $this->Cell(20,$incr,$mark_type,"L,T",1,"L");
            $this->SetXY(($initX+$size),$startY);
            if($mk == (count($mark_types)-1)){
                $this->Cell(20,$incr,"Total","L,T",1,"L");
                $this->SetXY(($initX+$size),$startY+$incr);
                $this->Cell(20,$incr,"Grade","L,T",1,"L");
                $initX = 50;
            }
        }

        $this->Rotate(0);
    }
    
    
    public function class_six($subject,$i)
    {

            if($i==1)
                    $w = 13.45;
            if($i==2)
                    $w = 13.35;
            if($i==3)
                    $w = 11.92;
            if($i==4)
                    $w = 11.15;
            if($i==5)
                    $w = 11.55;
            if($i==6)
                    $w = 11.85;
            if($i==7)
                    $w = 12.09;
            if($i==8)
                    $w = 12.25;
            if($i==9)
                    $w = 12.35;
            if($i==10)
                    $w = 12.02;
            if($i==11)
                    $w = 11.74;
            if($i==12)
                    $w = 11.5;
            if($i==13)
                    $w = 11.3;
            
            return $w;
    }
    
    public function class_seven($subject,$i)
    {

            if($i==1)
                    $w = 14.2;
            if($i==2)
                    $w = 14.2;
            if($i==3)
                    $w = 12.7;
            if($i==4)
                    $w = 11.85;
            if($i==5)
                    $w = 12.35;
            if($i==6)
                    $w = 12.65;
            if($i==7)
                    $w = 12.9;
            if($i==8)
                    $w = 13.05;
            if($i==9)
                    $w = 13.20;
            if($i==10)
                    $w = 12.83;
            if($i==11)
                    $w = 12.53;
            if($i==12)
                    $w = 12.26;
            
            return $w;
    }
    
    public function class_eight($subject,$i)
    {

            if($i==1)
                    $w = 20.5;
            if($i==2)
                    $w = 20.5;
            if($i==3)
                    $w = 18.95;
            if($i==4)
                    $w = 18;
            if($i==5)
                    $w = 17.5;
            if($i==6)
                    $w = 18;
            if($i==7)
                    $w = 18.40;
            if($i==8)
                    $w = 18.7;
            if($i==9)
                    $w = 18.3;
            if($i==10)
                    $w = 18.05;
            if($i==11)
                    $w = 18.25;
            return $w;
    }
    
    public function class_nine_s($subject,$i)
    {

            if($i==1)
                    $w = 9.38;
            if($i==2)
                    $w = 9.45;
            if($i==3)
                    $w = 7.98;
            if($i==4)
                    $w = 7.15;
            if($i==5)
                    $w = 7.6;
            if($i==6)
                    $w = 7.9;
            if($i==7)
                    $w = 8.15;
            if($i==8)
                    $w = 8.3;
            if($i==9)
                    $w = 8.45;
            if($i==10)
                    $w = 8.55;
            if($i==11)
                    $w = 8.65;
            
            return $w;
    }
    public function class_nine_b($subject,$i)
    {

            if($i==1)
                    $w = 9.38;
            if($i==2)
                    $w = 9.45;
            if($i==3)
                    $w = 7.98;
            if($i==4)
                    $w = 7.15;
            if($i==5)
                    $w = 7.6;
            if($i==6)
                    $w = 7.9;
            if($i==7)
                    $w = 8.15;
            if($i==8)
                    $w = 8.3;
            if($i==9)
                    $w = 8.45;
            if($i==10)
                    $w = 8.55;
            if($i==11)
                    $w = 8.65;
            return $w;
    }
    
    public function class_ten_s($subject,$i)
    {
            if($i==1)
                    $w = 6;
            if($i==2)
                    $w = 6;
            if($i==3)
                    $w = 4;
            if($i==4)
                    $w = 3;
            if($i==5)
                    $w = 2.40;
            if($i==6)
                    $w = 3;
            if($i==7)
                    $w = 3.425;
            if($i==8)
                    $w = 4.5;
            if($i==9)
                    $w = 5.340;
            if($i==10)
                    $w = 5.40;
//            if(preg_match('/gen/', strtolower($subject['subject_name'])))
//                    $w = 3;
//            if(preg_match('/acc/', strtolower($subject['subject_name'])))
//                    $w = 3.425;
//            if(preg_match('/bus/', strtolower($subject['subject_name'])))
//                    $w = 3.75;
//            if(preg_match('/int/', strtolower($subject['subject_name'])))
//                    $w = 4.0;
//            if(preg_match('/com/', strtolower($subject['subject_name'])))
//                    $w = 4.20;
            return $w;
    }
    
    public function class_ten_b($subject,$i)
    {
            if($i==1)
                    $w = 6;
            if($i==2)
                    $w = 6;
            if($i==3)
                    $w = 4;
            if($i==4)
                    $w = 3;
            if($i==5)
                    $w = 2.40;
            if($i==6)
                    $w = 3;
            if($i==7)
                    $w = 3.425;
            if($i==8)
                    $w = 3.75;
            if($i==9)
                    $w = 4.0;
            if($i==10)
                    $w = 4.20;
            return $w;
    }
    
    
    
    public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='') {
        //Output a cell
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) {
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3f Tw', $ws * $k));
            }
        }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
// begin change Cell function 12.08.2003
        if ($fill == 1 or $border > 0) {
            if ($fill == 1)
                $op = ($border > 0) ? 'B' : 'f';
            else
                $op='S';
            if ($border > 1) {
                $s = sprintf(' q %.2f w %.2f %.2f %.2f %.2f re %s Q ', $border, $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
            }
            else
                $s=sprintf('%.2f %.2f %.2f %.2f re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (is_int(strpos($border, 'L')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'l')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'T')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            else if (is_int(strpos($border, 't')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);

            if (is_int(strpos($border, 'R')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'r')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'B')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'b')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if (trim($txt) != '') {
            $cr = substr_count($txt, "\n");
            if ($cr > 0) { // Multi line
                $txts = explode("\n", $txt);
                $lines = count($txts);
                //$dy=($h-2*$this->cMargin)/$lines;
                for ($l = 0; $l < $lines; $l++) {
                    $txt = $txts[$l];
                    $w_txt = $this->GetStringWidth($txt);
                    if ($align == 'R')
                        $dx = $w - $w_txt - $this->cMargin;
                    elseif ($align == 'C')
                        $dx = ($w - $w_txt) / 2;
                    else
                        $dx=$this->cMargin;

                    $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                    if ($this->ColorFlag)
                        $s.='q ' . $this->TextColor . ' ';
                    $s.=sprintf('BT %.2f %.2f Td (%s) Tj ET ', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + (.7 + $l - $lines / 2) * $this->FontSize)) * $k, $txt);
                    if ($this->underline)
                        $s.=' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                    if ($this->ColorFlag)
                        $s.='Q ';
                    if ($link)
                        $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
                }
            }
            else { // Single line
                $w_txt = $this->GetStringWidth($txt);
                $Tz = 100;
                if ($w_txt > $w - 2 * $this->cMargin) { // Need compression
                    $Tz = ($w - 2 * $this->cMargin) / $w_txt * 100;
                    $w_txt = $w - 2 * $this->cMargin;
                }
                if ($align == 'R')
                    $dx = $w - $w_txt - $this->cMargin;
                elseif ($align == 'C')
                    $dx = ($w - $w_txt) / 2;
                else
                    $dx=$this->cMargin;
                $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                if ($this->ColorFlag)
                    $s.='q ' . $this->TextColor . ' ';
                $s.=sprintf('q BT %.2f %.2f Td %.2f Tz (%s) Tj ET Q ', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $Tz, $txt);
                if ($this->underline)
                    $s.=' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                if ($this->ColorFlag)
                    $s.='Q ';
                if ($link)
                    $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
            }
        }
        // end change Cell function 12.08.2003
        if ($s)
            $this->_out($s);
        $this->lasth = $h;
        if ($ln > 0) {
            //Go to next line
            $this->y+=$h;
            if ($ln == 1)
                $this->x = $this->lMargin;
        }
        else
            $this->x+=$w;
    }

    public function sample() {

        $cw = 6;
        $ch = 20;
        $X = 57;
        $Y = 60;
        $nX = 0;
        $nx = 0;
        $i = 0;
        foreach ($this->data['subjects'] as $k => $subject) {
            $subjectWidthN = (count($subject['mark_type']) * $cw) + (2 * $cw);

            $this->SetXY($X, $Y);
            foreach ($subject['mark_type'] as $j => $mt) {
                $mt = substr($mt, 0, 3);
                $this->Cell($cw, $ch, $mt, "L,T,B", 0, "C");
            }
            $this->Cell($cw, $ch, "T", "L,T,B", 0, "C");
            $this->Cell($cw, $ch, "G", "L,T,B", 0, "C");
            $X = $X + $subjectWidthN;
        }
    }

    public function Footer() {
        // Position at 1.5 cm from bottom
        //$this->SetY(-50);
        // Arial italic 8
        $this->SetMargins(10,0);
         // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
}

?>
