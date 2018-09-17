<?php

namespace app\controllers;

use Yii;
use app\models\Image;
use app\models\ImageModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for image model.
 */
class ImageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all image models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single image model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new image();
        if (isset($_POST["photo"])) {
            $data = $_POST["photo"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $datas = base64_decode($image_array_2[1]);
            $imageName = time() . '.png';
            $dir = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            file_put_contents($dir . $imageName, $datas);
            $model->name = $_POST['name'];
            $model->surname = $_POST['nickname'];
            $model->photos = $imageName;
            $model->save();
            return $this->redirect(['view', 'id' => $model->image_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing image model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        var_dump($model);
//        exit();
        if (isset($_POST["photo"])) {
            $data = $_POST["photo"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $datas = base64_decode($image_array_2[1]);
            $imageName = time() . '.png';
            $dir = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            if (file_exists($dir.$model->photos)){
                unlink($dir.$model->photos);
            }
            file_put_contents($dir . $imageName, $datas);
            $model->name = $_POST['name'];
            $model->surname = $_POST['nickname'];
            $model->photos = $imageName;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->image_id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $model->photos = $model->upload($model, 'photos');
//            $model->save();
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $dir = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        if (file_exists($dir.$model->photos)) {
            unlink($dir . $model->photos);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
