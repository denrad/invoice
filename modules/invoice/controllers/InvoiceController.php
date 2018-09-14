<?php

namespace app\modules\invoice\controllers;

use app\models\forms\InvoiceForm;
use app\models\InvoicePosition;
use Yii;
use app\models\Invoice;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
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
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InvoiceForm();

        if ($model->load(Yii::$app->request->post())) {
            // Загружаем множество позиций
            $formName = (new InvoicePosition())->formName();
            $invoicePositions = array_map(function (array $attributes) {
                return new InvoicePosition($attributes);
            }, \Yii::$app->request->post($formName));

            if ($model->save($invoicePositions)) {
                return $this->redirect(['invoice/view', 'id' => $model->id]);
            }
        } else {
            $invoicePositions = [new InvoicePosition()];
        }

        return $this->render('create', compact('model', 'invoicePositions'));
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
