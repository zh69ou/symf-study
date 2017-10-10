<?php

namespace User\ToolBundle\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/api/tool")
 */
class TooladController extends Controller
{
	/**
     * @Route("/codename", name="api_toolcode")
     */
    public function toolcode(Request $request)
    {
        $str=$this->getnum();
        while (!empty($this->getDoctrine()->getRepository('UserToolBundle:Tool')->findByCodenum($str))) {
        	$str=$this->getnum();
        }
        $data['codenum']=$str;
        return $this->json($data);
    }

    private function getnum($length=6)
    {
    	$str = "abcdefghijklmnopqrstuvwxyz1234567890";
    	$result="";
	    $l=strlen($str);
	    for($i=0;$i < $length;$i++){
	        $num = rand(0, $l-1); //如果$i不减1,将不一定生成4位数, 因为$num = rand(0,10).会随机产生10,$str[10] 为空
	        $result .= $str[$num];
	    }
	    return $result;
	}
}
