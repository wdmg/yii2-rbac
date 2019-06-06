<?php

namespace wdmg\rbac\controllers;

use Yii;
use wdmg\rbac\models\RbacAssignments;
use wdmg\rbac\models\RbacAssignmentsSearch;
use wdmg\rbac\models\RbacRoles;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AssignmentsController implements the CRUD actions for RbacAssignments model.
 */
class AssignmentsController extends Controller
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
     * Lists all RbacAssignments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RbacAssignmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RbacAssignments model.
     * @param string $item_name
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($item_name, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($item_name, $user_id),
        ]);
    }

    /**
     * Creates a new RbacAssignments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RbacAssignments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'item_name' => $model->item_name, 'user_id' => $model->user_id]);
        }

        //@TODO: ReBuild based on Yii::$app->getUser()->identityClass in future

        if(class_exists('\wdmg\users\models\Users') && isset(Yii::$app->modules['users']))
            $users = new \wdmg\users\models\Users();
        else
            $users = Yii::$app->getUser()->identityClass::className();

        $roles = new RbacRoles();

        return $this->render('create', [
            'users' => $users->getAllUsers(),
            'roles' => $roles->getAllRoles(),
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RbacAssignments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $item_name
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($item_name, $user_id)
    {
        $model = $this->findModel($item_name, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'item_name' => $model->item_name, 'user_id' => $model->user_id]);
        }

        //@TODO: ReBuild based on Yii::$app->getUser()->identityClass in future

        if(class_exists('\wdmg\users\models\Users') && isset(Yii::$app->modules['users']))
            $users = new \wdmg\users\models\Users();
        else
            $users = Yii::$app->getUser()->identityClass::className();

        $roles = new RbacRoles();

        return $this->render('update', [
            'users' => $users->getAllUsers(),
            'roles' => $roles->getAllRoles(),
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RbacAssignments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $item_name
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($item_name, $user_id)
    {
        $this->findModel($item_name, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RbacAssignments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $item_name
     * @param integer $user_id
     * @return RbacAssignments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($item_name, $user_id)
    {
        if (($model = RbacAssignments::findOne(['item_name' => $item_name, 'user_id' => $user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/modules/rbac', 'The requested page does not exist.'));
    }
}
