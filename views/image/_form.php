<?php

use richardfan\widget\JSRegister;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */

//if (!$model->isNewRecord){
//    var_dump($model->image_id);
//    exit();
//}
?>

    <div class="image-form">

        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin() ?>
                <?= $model->isNewRecord ? $form->field($model, 'image_id')->textInput(['id' => 'image_id'])->hiddenInput()->label(false) : $form->field($model, 'image_id')->textInput(['id' => 'image_id'])->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'name')->textInput(['id' => 'name']) ?>
                <?= $form->field($model, 'surname')->textInput(['id' => 'surname']) ?>
            </div>
        </div>
        <div class="row">
            <div class="well col-md-6">
                <?php if ($model->isNewRecord) : ?>
                    <div id="uploaded_image"></div>
                <?php else: ?>
                    <?= Html::img($model->photoViewer, ['class' => 'img-thumbnail', 'style' => 'width:200px;']) ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!$model->isNewRecord): ?>
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>

        <?php ActiveForm::end() ?>

        <div class="row">
            <div class="col-md-8">
                <html>
                <body>
                <br/>
                <div class="panel panel-default">
                    <div class="panel-body">

                        <input type="file" name="upload_ima ge" id="upload_image"/>
                    </div>
                </div>
                </body>
                </html>
            </div>
        </div>


        <div id="uploadimageModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload & Crop</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="image_demo" style="width:350px; margin-top:30px"></div>
                            </div>
                            <div class="col-md-4" style="padding-top:1px;">
                                <button class="btn btn-success crop_image">Crop & Upload Image</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if ($model->isNewRecord): ?>
    <?php JSRegister::begin(); ?>
    <script>
        $(document).ready(function () {
            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width: 360,
                    height: 480,
                    type: 'square'
                },
                boundary: {
                    width: 500,
                    height: 500
                }
            });

            $('#upload_image').on('change', function () {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').modal('show');
            });

            $('.crop_image').click(function (event) {
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (response) {
                    var name = $('#name').val();
                    let surname = $('#surname').val();
                    $.ajax({
                        url: "/image/create",
                        type: "POST",
                        data: {
                            "photo": response,
                            "name": name,
                            "nickname": surname
                        },
                        success: function (data) {
                            $('#uploadimageModal').modal('hide');
                            $('#uploaded_image').html(data);
                        }
                    });
                })
            });
        });
    </script>
    <?php JSRegister::end(); ?>

<?php else: ?>
    <?php JSRegister::begin(); ?>
    <script>
        $(document).ready(function () {
            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width: 360,
                    height: 480,
                    type: 'square'
                },
                boundary: {
                    width: 500,
                    height: 500
                }
            });

            $('#upload_image').on('change', function () {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').modal('show');
            });

            $('.crop_image').click(function (event) {
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (response) {
                    var name = $('#name').val();
                    let surname = $('#surname').val();
                    let id = $('#image_id').val();
                    $.ajax({
                        url: "http://localhost:8080/image/update?id=".id,
                        type: "POST",
                        data: {
                            "image_id": id,
                            "photo": response,
                            "name": name,
                            "nickname": surname
                        },
                        // success: function (data) {
                        //     $('#uploadimageModal').modal('hide');
                        //     $('#uploaded_image').html(data);
                        // }
                    });
                })
            });
        });
    </script>
    <?php JSRegister::end(); ?>


<?php endif; ?>