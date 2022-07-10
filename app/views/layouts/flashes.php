<?php
use aryelds\sweetalert\SweetAlert;
use lavrentiev\widgets\toastr\Notification;
?>
<?php foreach(Yii::$app->session->getAllFlashes() as $type => $messages): ?>
<?php foreach($messages as $message): 
    switch ($type) {
    case 'login-success':

        ?>
         
        <?php
    break;
    case 'success':

        Notification::widget(['type' => 'success', 'title' => 'Approved', 'message' => $message]);

    break;
    case 'successmessage':

        Notification::widget(['type' => 'success', 'title' => 'Success', 'message' => $message]);

        break;

    case 'Done':
        Notification::widget(['type' => 'success', 'title' => $type, 'message' => $message]);
        break;
    case 'tips':

        Notification::widget(['type' => 'info', 'title' => $type, 'message' => $message]);
        break;
    case 'successcreated':
        Notification::widget(['type' => 'success', 'title' => 'Created Successfully', 'message' => $message]);
        break;
    case 'successupdated':
        Notification::widget(['type' => 'success', 'title' => 'Created Successfully', 'message' => $message]);

        break;
    case 'successdeleted':
        Notification::widget(['type' => 'info', 'title' => 'Deleted', 'message' => $message]);
        break;    
    case 'exception':
        Notification::widget(['type' => 'info', 'title' => 'Error', 'message' => $message]);
        break;

    case 'register-error':
        $alertType = SweetAlert::TYPE_WARNING;
        echo SweetAlert::widget(['options' => ['title' => $type, 'text' => $message, 'type' => $alertType]]);
        ?>
        <script>
                document.getElementById('aregister').click()
        </script>
        <?php
    break;
    case 'register-success':
        $alertType = SweetAlert::TYPE_SUCCESS;
        echo SweetAlert::widget(['options' => ['title' => "Done", 'text' => $message, 'type' => $alertType]]);
        break;
    case 'login-error':
        $alertType = SweetAlert::TYPE_ERROR;
        echo SweetAlert::widget(['options' => ['title' => $type, 'text' => $message, 'type' => $alertType]]);
        ?>
        <script>
        document.getElementById('alogin').click()
        </script>
        <?php
    break;
    case 'errormessage':
        Notification::widget(['type' => 'error', 'title' => 'Error', 'message' => $message]);
    break; 
    default:
        echo SweetAlert::widget(['options' => ['title' => $type, 'text' => $message]]);
        ?>

        <script>
        $( document ).ready(function() {

        // Display an error toast, with a title
        document.getElementById('alogin').click()
        });
        </script>
        <?php
    break;
}

?>
  
    <!-- <div class="alert alert-<?=$type
?>" role="alert"><?=$message
?></div> -->
<?php
endforeach ?>
<?php
endforeach ?>
