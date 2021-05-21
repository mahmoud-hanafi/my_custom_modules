<?php

namespace Drupal\aun_system\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
use \Drupal\user\Entity\User;
use \Drupal\Core\Datetime\DrupalDateTime;
use \Drupal\Component\Datetime\DateTimePlus;

class import_staff extends FormBase{
  function getFormId() {
    return 'import_staff';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
  
    $form['description'] = array(
      '#markup' => '<h3> Use this form to upload a CSV file That Contains Staff Data.</h3>',
    );
    
    $form['import_csv'] = [
      '#type' => 'file',
      '#title' => $this->t('Import Results'),
      '#size' => 255,
      '#description' => $this->t('Select the CSV file to be imported.'),
      '#required' => FALSE,
      '#autoupload' => TRUE,
      '#upload_validators' => ['file_validate_extensions' => ['csv']],
    ];

    $form['actions']['#type'] = 'actions';


    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Import Results'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
  
    global $base_url;
  
    $academic_position_en = array( "1" =>"Demonstrator" , "2"=>"Assistant Lecturer" , "3"=>"Lecturer" , "4"=>"Associate Professor" , "5"=>"Professor");
    $academic_position_ar = array( "1" =>"معيد" , "2"=>"مدرس مساعد" , "3"=>"مدرس" , "4"=>"أستاذ مساعد" , "5"=>"أستاذ");
    
    $location = $_FILES['files']['tmp_name']['import_csv'];
    if (($handle = fopen($location, "r")) !== FALSE) {
      $keyIndex = [];
      $index = 0;
      $logVariationFields = "***************************** Content Import Begins ************************************ \n \n ";
      //$staff_count = 0;
      while (($data = fgetcsv($handle)) !== FALSE) {
        $index++;
        if($index < 2) {
          $i = 0;
          foreach ($data as $dataValues) {
            $header_value = iconv('windows-1256', 'UTF-8', $dataValues);
            //print $header_value."<br>";
            $file_header[] = $header_value;
            $i++;
          }
            continue;
        }
        $columns_count = count($data);
        $subject = "";
        for($x=4 ; $x<$columns_count ; $x++){
          $subject_title = $file_header[$x];
          $subject .= "$subject_title :  $data[$x] <br>";
        }
        

        $id = iconv('windows-1256', 'UTF-8', $data[0]);
        $staff_name = iconv('windows-1256', 'UTF-8', $data[1]);
        $staff_birth_date = iconv('windows-1256', 'UTF-8', $data[2]);
        $staff_national_id = iconv('windows-1256', 'UTF-8', $data[3]);
        $staff_work_place = iconv('windows-1256', 'UTF-8', $data[4]);
        $staff_general_specialty = iconv('windows-1256', 'UTF-8', $data[5]);
        $staff_department = iconv('windows-1256', 'UTF-8', $data[6]);
        $staff_degree = iconv('windows-1256', 'UTF-8', $data[7]);
        $staff_mobile = iconv('windows-1256', 'UTF-8', $data[8]);
        $staff_mail = iconv('windows-1256', 'UTF-8', $data[9]);
        $staff_official_mail = iconv('windows-1256', 'UTF-8', $data[10]);
        $staff_holiday_kind = iconv('windows-1256', 'UTF-8', $data[11]);
        $holiday_start = iconv('windows-1256', 'UTF-8', $data[12]);
        $holiday_end = iconv('windows-1256', 'UTF-8', $data[13]);
        
        
        $name = explode("/" , $staff_name);
        $username = $name[0].$name[1];
        
        if(!empty($staff_mobile)){
          $staff_mobile = "0".$staff_mobile;
        }
        else $staff_mobile="N/A";
    
        $staff_work_place_en = "Faculty of Alsun in Ismailia";
        $staff_academic_position = $academic_position_en[$staff_degree]." at ".$staff_work_place_en;
        $staff_academic_position_ar = $academic_position_ar[$staff_degree]." في ".$staff_work_place;
        $staff_user_type = 0;
        $birth_date = date("m-d-Y", strtotime($date)); 
        
        
        $user = User::create([
          'name' =>"$username",    
          'mail' => "$staff_official_mail",
          'pass' => "1234",
          'status' => 1,
          'roles' => array('faculty_staff'),
          'langcode' => 'en',
          'field_user_full_name' => array('value' =>$username),
          'field_user_email' => array('value' =>$staff_mail),
          'field_national_id' => array('value' =>$staff_national_id),
          'field_birth_date' => array('value' =>$birth_date),
          'field_user_department' => array('target_id' =>$staff_department),
          'field_user_mobile' => array('value' =>$staff_mobile),
          'field_general_specialty' => array('value' =>$staff_general_specialty),
          'field_academic_positions' => array('value' =>$staff_academic_position),
          'field_staff_academic_positions'=> array('value' =>$staff_degree),
          'field_user_type'=> array('value' =>$staff_user_type),
          'field_holiday_kind' => array('value' =>$staff_holiday_kind),
          'field_holiday_start' => array('value' =>$holiday_start),
          'field_holiday_end' => array('value' =>$holiday_end),
        ]);
        $user->save();

        
        print $id."----".$staff_name."-".$staff_mail."<br>";
        

        $user_ar = $user->addTranslation('ar');
        $user_ar->field_user_full_name->value = $username;
        $user_ar->field_user_email->value = $staff_mail;
        $user_ar->field_national_id->value = $staff_national_id;
        $user_ar->field_birth_date->value = $birth_date;
        $user_ar->field_user_department->target_id = $staff_department;
        $user_ar->field_user_mobile->value = $staff_mobile;
        $user_ar->field_general_specialty->value = $staff_general_specialty;
        $user_ar->field_academic_positions->value = $staff_academic_position_ar;
        $user_ar->field_staff_academic_positions->value = $staff_degree;
        $user_ar->field_user_type->value = $staff_user_type;
        $user_ar->field_holiday_kind->value = $staff_holiday_kind;
        $user_ar->field_holiday_start->value = $holiday_start;
        $user_ar->field_holiday_end->value = $holiday_end;
        $user_ar->save();
        
        
      }fclose($handle);
      exit;
    }
  }
}

?>
