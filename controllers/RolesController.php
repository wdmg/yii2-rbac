<?php

namespace wdmg\rbac\controllers;

use Yii;
use wdmg\rbac\models\RbacRoles;
use wdmg\rbac\models\RbacRolesSearch;
use wdmg\rbac\models\RbacRules;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RolesController implements the CRUD actions for RbacItems model.
 */
class RolesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'roles' => ['admin'],
                        'allow' => true
                    ],
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * Lists all RbacItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RbacRolesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RbacItems model.
     * @param string $id
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
     * Creates a new RbacItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RbacRoles();
        $roles = new RbacRules();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('create', [
            'rules' => $roles->getAllRules(),
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RbacItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $roles = new RbacRules();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', [
            'rules' => $roles->getAllRules(),
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RbacItems model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RbacItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RbacRoles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RbacRoles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/modules/rbac', 'The requested page does not exist.'));
    }
}
