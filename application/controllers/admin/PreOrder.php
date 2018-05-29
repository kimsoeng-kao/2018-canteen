<?php 
class PreOrder extends CI_Controller {
	 /**
    * Default constructor
    * @author kimsoeng kao <kimsoeng.kao@student.passerellesnumeriques.org>
    */
   public function __construct() {
       parent::__construct();
       log_message('debug', 'URI=' . $this->uri->uri_string());
       $this->session->set_userdata('last_page', $this->uri->uri_string());
       if($this->session->loggedIn === TRUE) {
          // Allowed methods
          if ($this->session->isAdmin || $this->session->isSuperAdmin) {
            //User management is reserved to admins and super admins
          }else {
            redirect(base_url());
          }
        } else {
          redirect('connection/login');
        }
       $this->load->model('UsersModel');
   }
   /**
    * Get all the food which are already ordered by the users
    * @author kimsoeng kao <kimsoeng.kao@student.passerellesnumeriques.org>
    */
	public function preOrderList(){
      $data['title'] = 'Pre Order Food';
      $this->load->view('templates/header', $data);
      $this->load->view('menu/adminDasboard', $data);
      $mealType = $this->uri->segment(4);
      $data['mealTypeId'] = 0;
        if ($mealType == 0 ) {
          $data['mealTypeId'] = $mealType;
          $data['dishes'] = $this->DishesModel->preOrderList();
        }else if($mealType != 0){
          $data['mealTypeId'] = $mealType;
          $data['dishes'] = $this->DishesModel->preOrderMealType($mealType);
        }
      $this->load->view('Admin/food/preOrder', $data);
      $this->load->view('templates/footer', $data);
  }

    /**
    * Get all the user who already order the dishes
    * @author kimsoeng kao <kimsoeng.kao@student.passerellesnumeriques.org>
    */
  public function userOrderList(){
    $data['userPreOrder'] = $this->UsersModel->userOrderList();
    $data['title'] = 'Users Pre-Ordered';
    $this->load->view('templates/header', $data);
    $this->load->view('menu/adminDasboard', $data);
    $this->load->view('Admin/users/userPreOrdered', $data);
    $this->load->view('templates/footer', $data);
  }

  /**
  * Export the Dishes which already ordered by the student or staffs
  * @author kimsoeng kao <kimsoeng.kao@student.passerellesnumeriques.org>
  */
  public function exportDishOrdered() {
    $data['dishPreOrder'] = $this->DishesModel->preOrderList();
    $this->load->view('Admin/food/exportDishOrdered',$data);
  }
  /**
  * Export the user who already the dishes
  * @author kimsoeng kao <kimsoeng.kao@student.passerellesnumeriques.org>
  */
  public function exportUserOrdered() {
    $data['userPreOrder'] = $this->UsersModel->userOrderList();
    $this->load->view('Admin/users/exportUserOrdered',$data);
  }
}
