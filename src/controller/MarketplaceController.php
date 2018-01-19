<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('model/SaleModel.php');
require_once('model/GearModel.php');
require_once('view/MarketplaceView.php');

class MarketplaceController
{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SaleModel();
        $this->view = new MarketplaceView($this->model);
    }

    public function showList() {
        $this->view->renderList();
    }

    public function showDetail($id) {

        $this->view->renderDetailView($id);
    }

    public function contactSeller($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $this->view->renderBuyContactForm($userId, $id);
    }

    public function processMessage() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        $cleanPOST = array_map('strip_tags', $_POST);

        if($cleanPOST['userId'] != $userId){
            $this->view->renderContactError("something went wrong");
            exit;
        }
        $saleById = $this->model->getSaleById((int)$cleanPOST['saleId']);

        if(!isset($saleById)){
            $this->view->renderContactError('Unknown Sale Id');
            exit;
        }

        $userModel = new UserModel();
        $seller = $userModel->getUserByUserName($saleById->seller);
        $user = $userModel->getUserById($userId);

        require 'modules/phpmailer/Exception.php';
        require 'modules/phpmailer/PHPMailer.php';
        require 'modules/phpmailer/SMTP.php';

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = getenv('MAIL_HOST');
            if( getenv('MAIL_USERNAME') ) {
                $mail->SMTPAuth = true;
                $mail->Username = getenv('MAIL_USERNAME');
                $mail->Password = getenv('MAIL_PASSWORD');
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
            }

            //Recipients
            $mail->setFrom(getenv('MAIL_FROM_ADDRESS'), 'MyGear');
            $mail->addAddress($seller->email, $seller->firstName.' '.$seller->lastName);
            $mail->addReplyTo($user->email, $user->firstName.' '.$user->lastName);
            $mail->addCC($user->email, $user->firstName.' '.$user->lastName);

            //Content
            $mail->isHTML(false);
            $mail->Subject = "Nachricht erhalten - \"$saleById->name\"";
            $mail->Body = $cleanPOST['message'];

            $mail->send();
            $this->view->renderContactConfirmation();
        } catch (Exception $e) {
            $this->view->renderContactError($mail->ErrorInfo);
        }
    }


    public function sell($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $saleById = $this->model->getSaleByGearId($id);
        if(isset($saleById)){
            $this->view->renderContactError('Already on sale');
            exit;
        }

        $gearModel = new GearModel();
        $gear = $gearModel->getGearById($userId, $id);
        if(isset($gear)){
            $this->view->renderSellForm($userId, $id);
        } else {
            $this->view->renderContactError('Gear not found or no permission');
        }
    }

    public function processSale() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;
        $cleanPOST = array_map('strip_tags', $_POST);
        $salesStart = date("Y-m-d H:i:s");

        if($cleanPOST['userId'] != $userId){
            $this->view->renderContactError("something went wrong");
            exit;
        }

        $gearModel = new GearModel();
        $gear = $gearModel->getGearById($userId, $cleanPOST['gearId']);
        if(!isset($gear)){
            $this->view->renderContactError('Gear not found or no permission');
            exit;
        }

        $saleById = $this->model->getSaleByGearId($cleanPOST['gearId']);
        if(isset($saleById)){
            $this->view->renderContactError('Already on sale');
            exit;
        }

        $sale = new Sale();
        $sale->description = $cleanPOST['description'];
        $sale->salesEnd = $cleanPOST['salesEnd']." 23:59:59";
        $sale->appearance = (int)$cleanPOST['appearanceId'];
        $sale->functioning = (int)$cleanPOST['functioningId'];
        $sale->packaging = (int)$cleanPOST['packagingId'];
        $sale->gearId = (int)$cleanPOST['gearId'];
        $sale->salesStart = $salesStart;
        $sale->salesPrice = (double)$cleanPOST['salesPrice'];

        $result = $this->model->addSale($userId, $sale);

        if(isset($result)) {
            header("location:/$language/Marketplace/showDetail/$result");
        } else {
            echo "Error insert";
        }
    }
}
