<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Alresia\LaravelWassenger\Wassenger;
use Alresia\LaravelWassenger\Messages;
use Alresia\LaravelWassenger\Devices;
use Alresia\LaravelWassenger\Exceptions\LaravelWassengerException;
use Alresia\LaravelWassenger\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Broadcast extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load_global();
        $this->load->model('Form_model', 'forms');
        $this->load->model('Orders_model', 'orders');
        $this->load->model('Form_bundles_model', 'form_bundles');
        $this->load->model('State_model', 'states');
        $this->load->model('Customers_model', 'customers'); // Load customers model for old customers
    }

    /**
     * Default view for Broadcast.
     */
    public function index()
    {
        $this->data['page_title'] = 'Broadcast';
        $this->load->view('broadcast', $this->data);
    }

    /**
     * Send message to orders or customers based on type and status.
     * @param string $type 'email' or 'whatsapp'
     * @param string $status Order status (optional)
     * @param bool $include_old_customers Include old customers in the broadcast
     */
    public function send_message()
    {


        $status = $this->input->post('status');
        $include_old_customers = $this->input->post('old_customers') == 'yes' ? true : false;
        $subject = $this->input->post('subject');

        $send_whatsapp = $this->input->post('send_whatsapp') == 'yes' ? true : false;
        $whatsapp_message = $this->input->post('whatsapp_message');


        $send_email = $this->input->post('send_email') == 'yes' ? true : false;
        $email_message = $this->input->post('email_message');

        $attachments = $this->input->post('attachments');


        $recipients = [];

        // Get orders by status
        if ($status) {
            $orders = $this->orders->get_orders_by_status($status);
            foreach ($orders as $order) {
                $recipients[] = [
                    'email' => $order->customer_email ?? null,
                    'whatsapp' => $order->customer_whatsapp ?? null,
                ];
            }
        }

        // Include old customers
        if ($include_old_customers) {
            $customers = $this->customers->get_old_customers();
            foreach ($customers as $customer) {
                $recipients[] = [
                    'email' => $customer->email ?? null,
                    'whatsapp' => $customer->whatsapp ?? null,
                ];
            }
        }

        // Send messages to all recipients
        log_message('error', 'Broadcasting messages to ' . json_encode($recipients));
        foreach ($recipients as $recipient) {
            if ($send_email) {
                $this->process_message('email', $recipient, $subject, $email_message, $attachments);
            }

            if ($send_whatsapp) {
                $this->process_message('whatsapp', $recipient, $subject, $whatsapp_message, $attachments);
            }
        }

        echo json_encode(['success' => true, 'message' => 'Messages sent successfully!']);

        // $this->session->set_flashdata('success', 'Messages sent successfully!');
        // redirect('broadcast');
    }

    /**
     * Helper function to process sending a message.
     */
    private function process_message($type, $recipient, $subject, $message, $media = null)
    {
        $store_id = get_current_store_id();
        $store_rec = get_store_details($store_id);

        if ($type === 'email' && !empty($recipient['email'])) {
            $this->send_email($recipient['email'], $subject, $message, $media, $store_rec);
        } elseif ($type === 'whatsapp' && !empty($recipient['whatsapp'])) {
            $this->send_whatsapp($recipient['whatsapp'], $subject, $message, $media);
        } else {
            log_message('error', "Invalid recipient or message type: " . json_encode($recipient));
        }
    }

    /**
     * Send an email using PHPMailer.
     */
    private function send_email($email, $subject, $message, $media, $store_rec)
    {
        $mail = new PHPMailer();
        try {
            if ($store_rec->smtp_status == 1) {
                $mail->isSMTP();
                $mail->Host = $store_rec->smtp_host;
                $mail->SMTPAuth = true;
                $mail->Username = $store_rec->smtp_user;
                $mail->Password = $store_rec->smtp_pass;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = $store_rec->smtp_port;
            }

            $mail->setFrom($store_rec->email, $store_rec->store_name);
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $message;

            if ($media) {
                $mail->addAttachment($media);
            }

            if (!$mail->send()) {
                log_message('error', "Email sending failed: " . $mail->ErrorInfo);
                log_message('error', "Email Error." . json_encode($mail));
            }
        } catch (Exception $e) {
            log_message('error', "PHPMailer error: " . $e->getMessage());
        }
    }

    /**
     * Send a WhatsApp message using the Messages class.
     */
    private function send_whatsapp($phone, $subject, $message, $media = null)
    {
        try {
            $msg = Messages::message($phone, '*' . $subject . '* \n\n' . $message);
            if ($media) {
                $msg->media($media);
            }
            $whatsapp = $msg->send();
            log_message('error', "whatsapp sent successfully." . json_encode($whatsapp));
        } catch (Exception $e) {
            log_message('error', "WhatsApp sending failed: " . $e->getMessage());
        }
    }
}
