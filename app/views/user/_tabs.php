<?php
Yii::$app->config->set('key1', 'value1');
Yii::$app->config->set('key1', 'value2');
?>

<style>
.project-tab {
    padding: 10%;
    margin-top: -8%;
}
.project-tab #tabs{
    background: #007b5e;
    color: #eee;
}
.project-tab #tabs h6.section-title{
    color: #eee;
}
.project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #0062cc;
    background-color: transparent;
    border-color: transparent transparent #f3f3f3;
    border-bottom: 3px solid !important;
    font-size: 16px;
    font-weight: bold;
}
.project-tab .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #0062cc;
    font-size: 16px;
    font-weight: 600;
}
.project-tab .nav-link:hover {
    border: none;
}

.project-tab a{
    text-decoration: none;
    color: #333;
    font-weight: 600;
}

</style>
  <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
                                <a class="nav-item nav-link" id="nav-theme-tab" data-toggle="tab" href="#nav-theme" role="tab" aria-controls="nav-theme" aria-selected="false">App Theme</a>
                                <a class="nav-item nav-link" id="nav-mail-tab" data-toggle="tab" href="#nav-mail" role="tab" aria-controls="nav-mail" aria-selected="false">Mail Server Settings</a>
                                <a class="nav-item nav-link" id="nav-rabitmq-tab" data-toggle="tab" href="#nav-rabitmq" role="tab" aria-controls="nav-rabitmq" aria-selected="false">Skill India Server Details</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                            <?= $this->render('__general') ?>

                            </div>
                            <div class="tab-pane fade " id="nav-theme" role="tabpanel" aria-labelledby="nav-theme-tab">
                             <?= $this->render('__theme') ?>

                            </div>
                            <div class="tab-pane fade" id="nav-mail" role="tabpanel" aria-labelledby="nav-mail-tab">
                             <?= $this->render('__mail') ?>

                            </div>
                            <div class="tab-pane fade" id="nav-rabitmq" role="tabpanel" aria-labelledby="nav-rabitmq-tab">
                              <?= $this->render('__rabitmq') ?>

                            </div>
                        </div>
                    </div>
                </div>


<script>
    $(document).ready(()=>{

    $('#<?= Yii::$app->config->get('active_tab','nav-general-tab'); ?>').trigger('click')
    })
</script>
