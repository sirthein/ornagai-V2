<?php

class Touch extends CI_Controller {

	
	function index()
	{
			$data['base']=$this->config->item('base_url');
            $data['login']=$this->session->userdata('logged_in');
            $data['title']="Ornagai::Touch";      
            //Check Mobile
            
            $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
            $data['theme']='jqt';
            	if ($iphone == true)  {
					$data['theme']='apple';
            	}
            	      
			$this->load->view('touch_view',$data);
	}
	
	function search()
	{
		$data['title']="Result for ".$_POST['search'];
		$data['base']=$this->config->item('base_url');
		$q=$_POST['search'];
		$page=1;
		$this->load->model('searchmodel');
        $myanmar=$this->searchmodel->detect_langauage($q);
	
        if($myanmar)
        {
   			$this->load->library("zawgyi");
    		$q=$this->zawgyi->normalize($q,"|",true);
        }
        $data['query']=$this->searchmodel->query($q,$myanmar,$page);
        $data['result']=$q;
        $data['mm']=$myanmar;
       
        $data['num_rows']=$this->searchmodel->query_numrows($q,$myanmar);
        
        $data['numshow']=10;
      
        if($data['query'])
        {
            $this->load->view("touch_result",$data);
        }
        else{
            echo "Can't Find";
        }
		
		
		
	}
}

?>