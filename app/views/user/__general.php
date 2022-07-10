<?php
   use yii\bootstrap\ActiveForm;
   use yii\bootstrap\Html;
?>

<div class="row mt-3">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>

        <div class="form-group row">
            <div class="col-sm-8">
                <div class="form-group row">
                    <label for="misname" class="control-label col-sm-4">MIS Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="general[mis-name]" class="text-uppercase"
                            maxlength="10" placeholder="MIS Name"
                            value="<?= Yii::$app->config->get('mis-name','skill mis'); ?>">

                    </div>
                </div>
                <div class="form-group row">
                    <label for="misname" class="control-label col-sm-4">Mail Footer</label>

                    <div class="col-sm-8">
                        <textarea class="form-control" name="general[mail-footer]" class="text-uppercase"
                            placeholder="Mail Footer" rows="4"
                            cols="50"><?= Yii::$app->config->get('mail-footer'); ?></textarea>

                    </div>
                </div>




                <!--  -->

                <div class="form-group row">
                    <label for="misname" class="control-label col-sm-4">First Trans Percentage</label>
                    <div class="col-sm-8">
                        <input type="number" max="40" class="form-control" name="general[trans_1]"
                            class="text-uppercase" maxlength="10"
                            value="<?= Yii::$app->config->get('trans_1','30'); ?>">

                    </div>
                </div>



                <div class="form-group row">
                    <label for="misname" class="control-label col-sm-4">Second Trans Percentage</label>
                    <div class="col-sm-8">
                        <input type="number" max="40" class="form-control" name="general[trans_2]"
                            class="text-uppercase" maxlength="10" placeholder="MIS Name"
                            value="<?= Yii::$app->config->get('trans_2','40'); ?>">

                    </div>
                </div>



                <div class="form-group row">
                    <label for="misname" class="control-label col-sm-4">Third Trans Percentage</label>
                    <div class="col-sm-8">
                        <input type="number" max="40" class="form-control" name="general[trans_3]"
                            class="text-uppercase" maxlength="10" placeholder=""
                            value="<?= Yii::$app->config->get('trans_3','30'); ?>">

                    </div>
                </div>


             
                <!--  -->
                <!--  -->

            </div>
        </div>

        <div class="form-group text-right">
        <?= Html::a('Welcome Mode', ['/site/index','welcome'=>true], ['target'=>'_blank']); ?>

            <?= Html::submitButton(Yii::t('app', "Update"), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>



    </div>

</div>
