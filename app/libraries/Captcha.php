<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha {

    protected $CI;
    private $sx;
    private $sy;
    private $rotation;

    public function __construct($x=200,$y=50,$r=50)
    {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();
        $this->sx=$x;
        $this->sy=$y;
        $this->rotation=$r;
    }    

    public function show()
    {
        $font = array( './captcha/fonts/stormfaze.ttf', 
                       './captcha/fonts/hemihead.ttf',
                       './captcha/fonts/leadcoat.ttf',
                       './captcha/fonts/stocky.ttf',
                       './captcha/fonts/arial.ttf' );
        // create a new captcha code                       
        $this->code =  chr(random_int(ord('A'),ord('Z')))
                      .chr(random_int(ord('A'),ord('Z')))
                      .chr(random_int(ord('A'),ord('Z')))
                      .chr(random_int(ord('A'),ord('Z')));
        $this->CI->session->set_userdata('captcha', $this->code);
        // send the captcha image
        header ('Content-Type: image/png');
        $im = @imagecreatetruecolor($this->sx, $this->sy);
        $background_color = imagecolorallocate($im, 0, 0, 0);
        imagecolortransparent ( $im, $background_color  );
        for( $n=0;$n<strlen($this->code);$n=$n+1){
          $color[$n] = imagecolorallocate($im, 150, 150, 150);
          
          imagettftext($im, random_int(20,28), random_int(-$this->rotation,$this->rotation),10+($n*($this->sx/4)), 30, 
                  $color[$n], $font[random_int(0,4)], $this->code[$n] );
        }           
        imagepng($im);
        imagedestroy($im); 
        exit;          
    }
      
    public function check($code)
    {
        return ($code==$this->code)?true:false;
    }
   
    public function create_html()
    {
      return $this->CI->load->view('/captcha/captcha',NULL,true);   
    }
 
}