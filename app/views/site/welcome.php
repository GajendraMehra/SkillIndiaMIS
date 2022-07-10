<?php
use app\models\Scheme;
use app\models\TpartnerDetail;
/* @var $this yii\web\View */

$this->title = 'Skill Development';
?>

<style>


</style>
<div class="site-index">

<?php
switch (Yii::$app->user->identity->role) {
    case '1':
        echo $this->render('../layouts/dashboard/admin.php');       # code...
    break;
    case '2':
        echo $this->render('../layouts/dashboard/trainingPartner.php');       # code...
    break;
    case '3':
        echo $this->render('../layouts/dashboard/trainingCenter.php');       # code...
    break;
    case '4':
        echo $this->render('../layouts/dashboard/accountant.php');       # code...
    break;

    default:
        # code...
        break;
}
?>
</div>

<s