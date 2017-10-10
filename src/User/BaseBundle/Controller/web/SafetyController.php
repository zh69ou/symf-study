<?php

namespace User\BaseBundle\Controller\web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use User\BaseBundle\Entity\User;
use User\BaseBundle\Entity\Forgetpsw;

/**
 * @Route("/{web}", defaults={"web"="index"}, requirements={"web":"(?!admin)\w+"})
 */
class SafetyController extends Controller
{
	/**
     * @Route("/login", name="login")
     */
	public function login($web)
	{
		if(!empty($this->getUser()))return $this->redirectToRoute('siteindex',array('web'=>$web));
		$helper = $this->get('security.authentication_utils');
		return $this->render('UserBaseBundle:Web:login.html.twig',array(
			'last_username' => $helper->getLastUsername(),
			'error' => $helper->getLastAuthenticationError(),
			));
	}

	/**
     * @Route("/register", name="register")
     */
	public function register(Request $request,$web)
	{
		if($request->isMethod('post')&&$this->isCsrfTokenValid('userregistercsrf', $request->request->get('_token'))&&$request->request->get('_agree')=='1')
		{
			$this->container->get('security.csrf.token_manager')->removeToken('userregistercsrf');
			$user = new User();
			$user->setUsername($request->request->get('username'));
			$user->setRegtime();
			$user->setApprove(0);
			$user->setState(1);
			$user->setRoles(array());
			if(!empty($request->request->get('email')))$user->setEmail($request->request->get('email'));
			if(!empty($request->request->get('phone')))$user->setPhone($request->request->get('phone'));
			$encoder = $this->container->get('security.password_encoder');
			$user->setPassword($encoder->encodePassword($user,$request->request->get('password')));
			$validator = $this->get('validator');
    		$errors = $validator->validate($user);
    		if(count($errors) == 0)
    		{
    			$manager = $this->getDoctrine()->getManager();
    			$manager->persist($user);
				$manager->flush();
				return $this->redirectToRoute('siteuser',array('web'=>$web));
    		}
		}
		return $this->render('UserBaseBundle:Web:register.html.twig');
	}

	/**
     * @Route("/land", name="land")
     */
	public function land()
	{
		throw new \Exception('This should never be reached!');
	}

	/**
     * @Route("/nodenied", name="nodenied")
     */
	public function nodenied()
	{
		return $this->render('UserBaseBundle:Web:nodenied.html.twig');
	}

	/**
     * @Route("/logout", name="logout")
     */
	public function logout()
	{
		throw new \Exception('This should never be reached!');
	}

	/**
     * @Route("/forpsw", name="forpsw")
     */
	public function forgetpsw(Request $request)
	{
		$error = [];
		if($request->isMethod('post')&&$this->isCsrfTokenValid('forpswcsrf', $request->request->get('_token')))
		{
			$this->container->get('security.csrf.token_manager')->removeToken('forpswcsrf');
			$user = new User();
			$user->setUsername($request->request->get('username'));
			$user->setEmail($request->request->get('email'));
			$validator = $this->get('validator');
    		$errors = $validator->validate($user);
    		if(count($errors) == 0)
    		{
	    		$user = $this->getDoctrine()->getRepository('UserBaseBundle:User');
	    		$user = $user->findOneByUsername($request->request->get('username'));
	    		if(!empty($user)&&$user->getEmail()==$request->request->get('email'))
	    		{
	    			$data['psw'] = $psw = md5(crypt($user->getEmail(), '$1$rasmusle$'));
	    			$message = \Swift_Message::newInstance()
				        ->setSubject('重置密码邮件')
				        ->setFrom('zhou69.1@163.com')
				        ->setTo($user->getEmail())
				        ->setBody($this->renderView('UserBaseBundle:Web:forgetpsw.html.twig',$data),'text/html')
				    ;

				    if($this->get('mailer')->send($message))
				    {
						$manager = $this->getDoctrine()->getManager();
				    	$fpsw = new Forgetpsw();
				    	$fpsw->setType('email');
				    	$fpsw->setContent($user->getEmail());
				    	$fpsw->setPswcode($psw);
				    	$fpsw->setIntime();
				    	$manager->persist($fpsw);
        				$manager->flush();
	        			$error['state'] = '0';
	        			$error['content'] = '发送成功！请在你的邮箱中执行接下来的操作。';
				    }
	    		}
			}
			if(empty($error))
			{
				$error['state'] = '1';
    			$error['content'] = '请正确填写用户名和邮箱！';
			}
		}
		return $this->render('UserBaseBundle:Web:forgetpsw.html.twig',$error);
	}

	/**
     * @Route("/respsw/{psw}", name="respsw", requirements={"psw": "\w+"})
     */
	public function respsw(Request $request,$web,$psw)
	{
		$for = $this->getDoctrine()->getRepository('UserBaseBundle:Forgetpsw');
	   	$for = $for->findOneByPswcode($psw);
	   	if(empty($for)||$for->getIntime()<date('Y-m-d H:i:s',time()))return $this->redirectToRoute('index');
	   	if($request->isMethod('post')&&$this->isCsrfTokenValid('repassword', $request->request->get('_token')))
	   	{
	   		$user = $this->getDoctrine()->getRepository('UserBaseBundle:User');
	   		$user = $user->findOneByEmail($for->getContent());
	   		$manager = $this->getDoctrine()->getManager();
	   		$encoder = $this->container->get('security.password_encoder');
			$user->setPassword($encoder->encodePassword($user,$request->request->get('password')));
			$manager->persist($user);
			$manager->remove($for);
    		$manager->flush();
    		return $this->redirectToRoute('login',array('web'=>$web));
	   	}
	   	return $this->render('UserBaseBundle:Web:repsw.html.twig');
	}

	/**
     * @Route("/uppsw", name="uppsw")
     */
	public function uppsw(Request $request)
	{
		$error = [];
		if($request->isMethod('post')&&$this->isCsrfTokenValid('uppassword', $request->request->get('_token')))
		{
			$this->container->get('security.csrf.token_manager')->removeToken('uppassword');
			$encoder = $this->container->get('security.password_encoder');
			if($encoder->isPasswordValid($this->getUser(),$request->request->get('opassword'))){
				$manager = $this->getDoctrine()->getManager();
				$user = $this->getUser();
				$user->setPassword($encoder->encodePassword($user,$request->request->get('password')));
				$manager->persist($user);
        		$manager->flush();
        		if($user->getId())
        		{
        			$error['state'] = '0';
        			$error['content'] = '修改成功！';
        		}
			}

			if(empty($error)){
        		$error['state'] = '1';
        		$error['content'] = '修改失败，请联系管理员！';
			}
		}
		return $this->render('UserBaseBundle:Web:uppsw.html.twig',$error);
	}

	/**
     * @Route("/myinfo", name="myinfo")
     */
	public function myinfo(Request $request)
	{
		$error = [];
		if($request->isMethod('post')&&$this->isCsrfTokenValid('upmyinfo', $request->request->get('_token')))
		{
			$this->container->get('security.csrf.token_manager')->removeToken('upmyinfo');
			$manager = $this->getDoctrine()->getManager();
			$user = $this->getUser();
			$user->setEmail($request->request->get('email'));
			$user->setPhone($request->request->get('phone'));
			$file = $request->files->get('himg');
			// var_dump($file->getClientOriginalName());exit;
			if(!empty($file))$user->setHimg($file);
			$validator = $this->get('validator');
    		$errors = $validator->validate($user);
    		// var_dump((string)$errors);exit;
    		if (count($errors) > 0)
    		{
    			$error['state'] = '1';
        		$error['content'] = '修改失败!传入数据错误，如有疑问请联系管理员！';
    		}else{
    			if(!empty($file))
    			{
					$filename = md5(uniqid()).'.'.$file->guessExtension();
					$url = 'uploads/'.$user->getId().'/';
					$dir = $this->container->getParameter('kernel.root_dir').'/../web/'.$url;
					$file->move($dir,$filename);
					$user->setHimg($url.$filename);
    			}
				$manager->persist($user);
				$manager->flush();
				$error['state'] = '0';
        		$error['content'] = '修改成功！';
    		}
		}
		return $this->render('UserBaseBundle:Web:myinfo.html.twig',$error);
	}

	/**
     * @Route("/delhimg", name="delhimg")
     */
	public function delhimg($web)
	{
		$user = $this->getUser();
		if(!empty($user->getHimg()))
		{
			@unlink($this->container->getParameter('kernel.root_dir').'/../web/'.$user->getHimg());
			$manager = $this->getDoctrine()->getManager();
			$user->setHimg('');
			$manager->persist($user);
			$manager->flush();
		}
		return $this->redirectToRoute('myinfo',array('web'=>$web));
	}
}
