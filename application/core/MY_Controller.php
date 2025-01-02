<?php

/**
 * Author: Askarali
 */

use Dompdf\Dompdf;
use Dompdf\Options;
use Alresia\LaravelWassenger\Wassenger;
use Alresia\LaravelWassenger\Messages;
use Alresia\LaravelWassenger\Devices;
use Alresia\LaravelWassenger\Exceptions\LaravelWassengerException;
use Alresia\LaravelWassenger\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MY_Controller extends CI_Controller
{
  public $source_version = "1.7.1";
  public function __construct()
  {
    parent::__construct();

    //$this->output->enable_profiler(TRUE);

    //Used after logout
    if (!empty($this->input->cookie("language"))) {
      $this->session->set_userdata('language', $this->input->cookie("language"));

      $cookie = array(
        'name'   => 'language',
        'value'  => '',
        'expire' => '0',
      );
      $this->input->set_cookie($cookie);
    }
    //end

    $default_lang = ($this->session->has_userdata('language')) ? $this->session->userdata('language') : "English";

    $this->lang->load($default_lang, $default_lang);
    $this->load->library('email');
    $this->load->config('order_status');
  }
  public function load_info()
  {
    /*if(strtotime(date("d-m-Y")) >= strtotime(date("05-04-2019"))){
            echo "License Expired! Contact Admin";exit();
          }*/

    //CHECK LANGUAGE IN SESSION ELSE FROM DB
    if (!$this->session->has_userdata('language') && $this->session->has_userdata('logged_in')) {
      $this->load->model('language_model');
      $this->language_model->set(get_current_store_language());
    }
    if ($this->session->has_userdata('logged_in')) {
      $this->lang->load($this->session->userdata('language'), $this->session->userdata('language'));
    }
    //End

    //If currency not set retrieve from DB
    $this->load_currency_data();
    //end



    $query = $this->db->select('site_name,version')->where('id', 1)->get('db_sitesettings');

    $this->db->select('store_name,timezone,time_format,date_format,decimals');
    if ($this->session->userdata('logged_in')) {
      $this->db->where('id', get_current_store_id());
    } else {
      $this->db->where('id', 1);
    }
    $this->db->from('db_store');
    $query1 = $this->db->get();

    date_default_timezone_set(trim($query1->row()->timezone));

    $time_format = ($query1->row()->time_format == '24') ? date("h:i:s") : date("h:i:s a");

    $date_view_format = trim($query1->row()->date_format);
    $this->session->set_userdata(array('view_date'  => $date_view_format));
    $this->session->set_userdata(array('view_time'  => $query1->row()->time_format));
    $this->session->set_userdata(array('decimals'  => $query1->row()->decimals));
    $this->session->set_userdata(array('store_name'  => $query1->row()->store_name));

    $this->data = array(
      'theme_link'    => base_url() . 'theme/',
      'base_url'      => base_url(),
      'SITE_TITLE'    => $query->row()->site_name,
      'VERSION'       => $query->row()->version,
      'CURRENCY'      => $this->session->userdata('currency'),
      'CURRENCY_PLACE' => $this->session->userdata('currency_placement'),
      'CURRENCY_CODE' => $this->session->userdata('currency_code'),
      'CUR_DATE'      => date("Y-m-d"),
      'VIEW_DATE'     => $date_view_format,
      'CUR_TIME'      => $time_format,
      'SYSTEM_IP'     => $_SERVER['REMOTE_ADDR'],
      'SYSTEM_NAME'   => gethostbyaddr($_SERVER['REMOTE_ADDR']),
      'CUR_USERNAME'  => $this->session->userdata('inv_username'),
      'CUR_USERID'    => $this->session->userdata('inv_userid'),
    );
  }
  public function load_currency_data()
  {
    if ($this->session->userdata('logged_in')) {
      $q1 = $this->db->query("SELECT a.currency_name,a.currency,a.currency_code,a.symbol,b.currency_placement FROM db_currency a,db_store b WHERE a.id=b.currency_id AND b.id=" . get_current_store_id());
      $currency = $q1->row()->currency;
      $currency_placement = $q1->row()->currency_placement;
      $currency_code = $q1->row()->currency_code;
      $this->session->set_userdata(array('currency'  => $currency, 'currency_placement'  => $currency_placement, 'currency_code'  => $currency_code));
    } else {
      $this->session->set_userdata(array('currency'  => '', 'currency_placement'  => '', 'currency_code'  => ''));
    }
  }

  public function verify_store_and_user_status()
  {
    $store_rec = get_store_details();
    //STORE ACTIVE OR NOT
    if (!$store_rec->status) {
      $this->session->set_flashdata('failed', 'Your Store Temporarily Inactive!');
      redirect('logout');
      exit;
    }
    //USER ACTIVE OR NOT
    if (!get_user_details()->status) {
      $this->session->set_flashdata('failed', 'Your account is temporarily inactive!');
      redirect('logout');
      exit;
    }
  }
  public function load_global($validate_subs = 'VALIDATE')
  {
    //Check login or redirect to logout
    if ($this->session->userdata('logged_in') != 1) {
      redirect(base_url() . 'logout', 'refresh');
    }

    $this->verify_store_and_user_status();

    $this->load_info();
  }

  // public function currency($value='',$with_comma=false){
  //   $value = trim($value);

  //   if(!empty($value) && is_numeric($value)){
  //     $value= ($with_comma) ? store_number_format($value) : store_number_format($value,false);
  //   }

  //   if($this->session->userdata('currency_placement')=='Left'){
  //     if(!empty($value)){
  //       return $this->session->userdata('currency')." ".$value;
  //     }
  //     return $this->session->userdata('currency')."".$value;

  //   }
  //   else{
  //     if(!empty($value)){
  //       return $value." ".$this->session->userdata('currency');    
  //     }
  //    return $value."".$this->session->userdata('currency'); 
  //   }
  // }


  public function currency($value = '', $with_comma = false)
  {
    $value = trim($value);

    // Format the number if it's numeric
    if (!empty($value) && is_numeric($value)) {
      $value = ($with_comma) ? store_number_format($value) : store_number_format($value, false);
    }

    // Get currency and placement from session or use defaults
    $currency = $this->session->userdata('currency') ?? '₦'; // Default currency
    $placement = $this->session->userdata('currency_placement') ?? 'Left'; // Default placement

    // Format the value with currency
    if ($placement === 'Left') {
      return !empty($value) ? $currency . " " . $value : $currency . $value;
    } else {
      return !empty($value) ? $value . " " . $currency : $value . $currency;
    }
  }



  public function store_wise_currency($store_id, $value = '')
  {

    $q1 = $this->db->query("SELECT a.currency_name,a.currency,a.currency_code,a.symbol,b.currency_placement FROM db_currency a,db_store b WHERE a.id=b.currency_id AND b.id=" . $store_id);
    $currency = $q1->row()->currency;
    $currency_placement = $q1->row()->currency_placement;
    $currency_code = $q1->row()->currency_code;

    $value = trim($value);
    if (!empty($value) && is_numeric($value)) {
      $value = number_format($value, 2, '.', '');
    }
    if ($currency_placement == 'Left') {
      if (!empty($value)) {
        return $currency . " " . $value;
      }
      return $currency . "" . $value;
    } else {
      if (!empty($value)) {
        return $value . " " . $currency;
      }
      return $value . "" . $currency;
    }
  }

  public function currency_code($value = '')
  {
    if (!empty($this->session->userdata('currency_code'))) {
      if ($this->session->userdata('currency_placement') == 'Left') {
        return $this->session->userdata('currency_code') . " " . $value;
      } else {
        return $value . " " . $this->session->userdata('currency');
      }
    } else {
      return $value;
    }
  }
  public function permissions($permissions = '')
  {
    //If he the Admin
    if ($this->session->userdata('inv_userid') == 1) {
      return true;
    }

    $tot = $this->db->query('SELECT count(*) as tot FROM db_permissions where permissions="' . $permissions . '" and role_id=' . $this->session->userdata('role_id'))->row()->tot;
    if ($tot == 1) {
      return true;
    }
    return false;
  }

  public function permission_check($value = '')
  {
    if (!$this->permissions($value)) {
      show_error("Access Denied", 403, $heading = "You Don't Have Enough Permission!!");
    }
    return true;
  }
  public function permission_check_with_msg($value = '')
  {
    if (!$this->permissions($value)) {
      echo "You Don't Have Enough Permission for this Operation!";
      exit();
    }
    return true;
  }
  public function show_access_denied_page()
  {
    show_error("Access Denied", 403, $heading = "You Don't Have Enough Permission!!");
  }
  //end
  public function get_current_version_of_db()
  {
    return $this->db->select('version')->from('db_sitesettings')->get()->row()->version;
  }

  public function belong_to($table, $rec_id)
  {
    if (!is_it_belong_to_store($table, $rec_id)) {
      show_error("Data may not avaialable!!", 403, $heading = "Something Went Wrong!!");
    }
  }

  public function send_order_messages($order, $status, $type = 'whatsapp')
  {
    $template = $this->orders->get_message($status, $type);
    $fileName = strtolower(str_replace(' ', '-', $order->customer_name . '-' . $order->state . '-' . $order->order_number));

    if ($template[0]->send_message) {
      $message = $this->resolveTemplate($order, $template[0]->message);
      $subject = $this->resolveTemplate($order, $template[0]->subject);

      $media = [];


      $imagePath = !empty($order->bundle_image)
        ? FCPATH . return_item_image_thumb($order->bundle_image)
        : FCPATH . "theme/images/no_image.png";

      $imageUrl = file_exists($imagePath)
        ? base_url(return_item_image_thumb($order->bundle_image))
        : base_url("theme/images/no_image.png");

      $data = $this->data;
      $data['page_title'] = "Orders Receipt";
      $data['order_id'] = $order->id;

      // Load the view and capture its HTML content
      $html = $this->load->view('orders/receipt-pdf', $data, true);

      // Generate and return the PDF (temporary file)
      $pdfFilePath = $this->generatePDFfromPage($html, null, false);
      $pdfFileUrl = base_url('/orders/receipt/' . $order->id . '?file_name=' . $fileName);


      if ($template[0]->send_image) {
        // $media[] = ['url' => $imageUrl];
        $media = ['url', $imageUrl];
      }

      if ($template[0]->send_pdf) {
        // $media[] = ['url' => $pdfFilePath];
        $media = ['url', $pdfFileUrl];
      }


      log_message('error', "Sending to customer_whatsapp:" . json_encode([
        'customer_whatsapp' => $order->customer_whatsapp,
        'customer_phone' => $order->customer_phone,
        'message' => $message,
        'media' => $media,
      ]));

      try {
        // Send WhatsApp message via Messages API
        Messages::message($this->toCountryCode($order->customer_whatsapp), '*' . $subject . '* \n\n' . $message)
          ->media($media)
          ->send();

        // if ($order->customer_whatsapp != $order->customer_phone) {
        //   Messages::message($this->toCountryCode($order->customer_phone), '*' . $subject . '* \n\n' . $message)
        //     ->media($media)
        //     ->send();
        // }
      } catch (LaravelWassengerException $e) {
        // Handle exception
        log_message('error', "LaravelWassengerException:" . $e->getMessage());
      }

      // Clean up temporary file
      if (file_exists($pdfFilePath)) {
        unlink($pdfFilePath);
      }
    }
  }

  public function send_order_message($order, $status, $type = 'whatsapp')
  {
    $template = $this->orders->get_message($status, $type);
    $fileName = strtolower(str_replace(' ', '-', $order->customer_name . '-' . $order->state . '-' . $order->order_number));

    if ($template[0]->send_message) {
      // Resolve the message and subject
      $message = $this->resolveTemplate($order, $template[0]->message);
      $subject = $this->resolveTemplate($order, $template[0]->subject);

      // Prepare attachments (image and PDF)
      $whatsAppMedia = [];
      $emailMedia = [];

      // Prepare image attachment
      $imagePath = !empty($order->bundle_image)
        ? FCPATH . return_item_image_thumb($order->bundle_image)
        : FCPATH . "theme/images/no_image.png";

      $imageUrl = file_exists($imagePath)
        ? base_url(return_item_image_thumb($order->bundle_image))
        : base_url("theme/images/no_image.png");

      if ($template[0]->send_image) {
        $whatsAppMedia[] = ['url', $imageUrl];
        $emailMedia[] = $imagePath;
      }

      // Prepare PDF receipt
      $data = $this->data;
      $data['page_title'] = "Orders Receipt";
      $data['order_id'] = $order->id;

      $html = $this->load->view('orders/receipt-pdf', $data, true);
      $pdfFilePath = $this->generatePDFfromPage($html, null, false);
      $pdfFileUrl = base_url('/orders/receipt/' . $order->id . '?file_name=' . $fileName);

      if ($template[0]->send_pdf) {
        $whatsAppMedia[] = ['url', $pdfFileUrl];
        $emailMedia[] = $pdfFilePath;
      }

      // // Send Email
      // if ($type === 'email') {
      //   $store_id = (isset($store_id) && !empty($store_id)) ? $store_id : get_current_store_id();
      //   $store_rec = get_store_details();
      //   $smtp_status = $store_rec->smtp_status;

      //   $this->load->library('email');
      //   if ($smtp_status == 1) {
      //     $config = array(
      //       'protocol' => 'smtp',
      //       'smtp_host' => $store_rec->smtp_host,
      //       'smtp_port' => $store_rec->smtp_port,
      //       'smtp_user' => $store_rec->smtp_user,
      //       'smtp_pass' => $store_rec->smtp_pass,
      //       'smtp_crypto' => 'ssl',
      //       'mailtype' => 'text',
      //       'smtp_timeout' => '4',
      //       'charset' => 'iso-8859-1',
      //       'wordwrap' => TRUE
      //     );
      //     $this->email->initialize($config);
      //   }

      //   $this->email->set_mailtype("html");
      //   $this->email->set_newline("\r\n");
      //   $this->email->from($store_rec->smtp_user, $store_rec->store_name);
      //   $this->email->to($order->customer_email);
      //   $this->email->subject($subject);
      //   $this->email->message($message);

      //   // Attach files
      //   if (isset($media[0]['url'])) {
      //     $this->email->attach($media['url']);
      //   }

      //   if (!$this->email->send()) {
      //     log_message('error', "Email sending failed: " . $this->email->print_debugger());
      //   } else {
      //     log_message('error', "Email sent: " . $this->email->print_debugger());
      //   }
      // }
      // Send Email using PHPMailer
      if ($type === 'email') {
        $store_id = (isset($store_id) && !empty($store_id)) ? $store_id : get_current_store_id();
        $store_rec = get_store_details();
        $smtp_status = $store_rec->smtp_status;

        // Load PHPMailer
        $mail = new PHPMailer();

        try {
          // Configure SMTP if enabled
          if ($smtp_status == 1) {
            $mail->isSMTP();
            $mail->Host = $store_rec->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $store_rec->smtp_user;
            $mail->Password = $store_rec->smtp_pass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $store_rec->smtp_port;
          }

          // Email sender and recipient
          $mail->setFrom($store_rec->email, $store_rec->store_name);
          $mail->addAddress($order->customer_email);

          // Subject and message
          $mail->Subject = $subject;
          $mail->isHTML(true); // Set email format to HTML
          $mail->Body = $message;

          // Attach files if any
          if (isset($emailMedia[0])) {
            $mail->addAttachment($emailMedia[0]);
            log_message('error', "Email attaching  media." . json_encode($emailMedia[0]));
          }

          // Send email
          if ($mail->send()) {
            log_message('error', "Email sent successfully." . json_encode($mail));
          } else {
            log_message('error', "Email sending failed: " . $mail->ErrorInfo);
          }
        } catch (Exception $e) {
          log_message('error', "PHPMailer error: " . $mail->ErrorInfo);
        }
      }

      // Send WhatsApp
      if ($type === 'whatsapp') {
        log_message('error', "Sending WhatsApp message: " . json_encode([
          'customer_whatsapp' => $order->customer_whatsapp,
          'customer_phone' => $order->customer_phone,
          'message' => $message,
          'media' => $whatsAppMedia[0],
        ]));

        // try {
        //   Messages::message($this->toCountryCode($order->customer_whatsapp), '*' . $subject . '* \n\n' . $message)
        //     ->media($media[0] ?? [])
        //     ->send();
        // } catch (LaravelWassengerException $e) {
        //   log_message('error', "WhatsApp Message Error: " . $e->getMessage());
        // }
        try {
          // Send the message
          $message = Messages::message($this->toCountryCode($order->customer_whatsapp), '*' . $subject . '* \n\n' . $message);

          // Attach media if it exists
          if (isset($whatsAppMedia[0])) {


            $message->media($whatsAppMedia[0]);
            log_message('error', "whatsapp attaching  media." . json_encode($whatsAppMedia[0]));
          }

          // Send the message
          $whatsapp = $message->send();
          log_message('error', "whatsapp sent successfully." . json_encode($whatsapp));
        } catch (LaravelWassengerException $e) {
          log_message('error', "WhatsApp Message Error: " . $e->getMessage());
        }
      }

      // Clean up temporary PDF file
      if (file_exists($pdfFilePath)) {
        unlink($pdfFilePath);
      }
    }
  }




  public function toCountryCode($phone, $cCode = '+234', $nMax = 10)
  {

    //Get the last character.
    $lastNum = $phone[strlen($phone) - 1];
    $formatNum = $cCode . '' . substr($phone, -$nMax, -1) . '' . $lastNum;
    return $formatNum;
    // echo toCountryCode('2349022233344').'<br>'; //Must Result +2349022233344
    // echo toCountryCode('09022233344').'<br>'; //Must Result +2349022233344
    // echo toCountryCode('+23409022233344').'<br>'; //Must Result +2349022233344
    // echo toCountryCode('23409022233344').'<br>'; //Must Result +2349022233344
  }

  public function break_text($text, $return = 10)
  {
    $newString = substr($text, 0, $return);
    if (strlen($text) < $return) {
      return $newString;
    } else {
      return $newString . '...';
    }
  }

  public function resolveTemplate($order, $template)
  {
    $statuses = $this->config->item('order_status');
    $status = $statuses[$order->status]['label'];
    // Extract order details
    $date = new DateTime($order->delivery_date);
    $today = new DateTime('today');
    $tomorrow = new DateTime('tomorrow');
    $order_date =  date('jS \of M, Y \a\t g:ia', strtotime($order->order_date)); // Use your date formatting function
    if ($date->format('Y-m-d') == $today->format('Y-m-d')) {
      $delivery_date = 'Today, ' . $date->format('jS F, Y');
    } elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
      $delivery_date = 'Tomorrow, ' . $date->format('jS F, Y');
    } else {
      $delivery_date = $date->format('l, jS F, Y');
    }
    // Map placeholders to their corresponding order properties

    $placeholders = [
      '[order_number]' => $order->order_number,
      '[customer_name]' => $order->customer_name,
      '[customer_phone]' => $order->customer_phone,
      '[customer_whatsapp]' => $order->customer_whatsapp,
      '[customer_email]' => $order->customer_email,
      '[customer_address]' => $order->address,
      '[order_date]' => $order_date,
      '[rescheduled_date]' => $order->rescheduled_date,
      '[delivery_date]' => $delivery_date,
      '[status]' => $status,
      '[country]' => $order->country,
      '[state]' => $order->state,
      '[quantity]' => $order->quantity,
      '[amount]' => $this->currency($order->amount, true),
      '[bundle_name]' => $order->bundle_name,
      '[bundle_image]' => $order->bundle_image,
      '[bundle_description]' => $order->bundle_description,
      '[bundle_price]' => $this->currency($order->bundle_price, true),
      '[discount_type]' => $order->discount_type,
      '[discount_amount]' => $order->discount_amount,
    ];

    // Calculate the discount price
    if ($order->discount_type === 'percentage') {
      $discount_price = $order->amount - ($order->amount * ($order->discount_amount / 100));
    } else {
      $discount_price = $order->amount - $order->discount_amount;
    }
    $placeholders['[discount_price]'] = $discount_price;

    // Replace all placeholders in the template
    foreach ($placeholders as $placeholder => $value) {
      $template = str_replace($placeholder, $value, $template);
    }

    return $template;
  }

  public function generatePDFfromPage($htmlContent, $fileName = null, $stream = true, $download = false)
  {
    // Load Dompdf
    $options = new Options();

    // $options->set('defaultFont', 'Courier');
    $options->set('isRemoteEnabled', true);
    $options->set('tempDir', sys_get_temp_dir()); // Use a writable temp directory
    $options->set('httpContext', stream_context_create([
      'http' => [
        'timeout' => 30, // Increase timeout
      ]
    ]));
    $dompdf = new Dompdf($options);



    // Load the HTML content into Dompdf
    $dompdf->loadHtml($htmlContent);



    // Set the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as a PDF
    $dompdf->render();

    if ($stream) {
      // Stream the PDF to the browser
      $dompdf->stream($fileName ?? 'document.pdf', ["Attachment" => $download]);
    } else {
      // Generate a unique file name if not provided
      $fileName = $fileName ?? uniqid('order_receipt_') . '.pdf';
      $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName; // Temporary directory

      // Save the PDF content to the file
      file_put_contents($filePath, $dompdf->output());
      return $filePath;
    }
  }
}
