<?php

namespace frontend\controllers;


use core\access\Rbac;
use core\forms\BlogForm;
use core\forms\CommentForm;
use core\repositories\BlogRepository;
use core\services\BlogService;
use core\services\CommentService;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BlogController extends Controller
{
    private $repository;
    private $service;

    public function __construct($id, Module $module, BlogRepository $repository, BlogService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'edit'],
                'rules' => [
                    [
                        'actions' => ['create', 'edit'],
                        'allow' => true,
                        'roles' => [Rbac::ROLE_USER],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($category = null)
    {
        $category = $category ? $this->repository->getCategoryBySlug($category) : null;
        $search = Yii::$app->request->get('search', '');
        $provider = $this->repository->getProvider($category, $search);

        return $this->render('index', [
            'category' => $category,
            'provider' => $provider,
            'search' => $search,
        ]);
    }

    public function actionView($category, $post)
    {
        $category = $this->repository->getCategoryBySlug($category);
        $blog = $this->repository->getByCategoryAndSlug($category->id, $post);
        $this->repository->updateViews($blog);

        $commentForm = new CommentForm();
        if ($commentForm->load(Yii::$app->request->post()) && $commentForm->validate()) {
            /* @var $commentService CommentService */
            $commentService = Yii::$container->get(CommentService::class);
            $commentService->addComment($commentForm, $blog);
            return $this->redirect($blog->getUrl(false, 'comments'));
        }

        return $this->render('view', [
            'blog' => $blog,
            'commentModel' => $commentForm,
        ]);
    }

    public function actionCreate()
    {
        $form = new BlogForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $blog = $this->service->create($form);
                return $this->redirect(['/blog/view', 'category' => $blog->category->slug, 'post' => $blog->slug]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', [['Ошибка', $e->getMessage()]]);
            }
        }

        return $this->render('create', [
            'model' => $form,
            'blog' => null,
        ]);
    }

    public function actionEdit($category, $post)
    {
        $blog = $this->repository->getBySlug($post);
        if (!Yii::$app->user->can(Rbac::PERMISSION_MANAGE, ['user_id' => $blog->id])) {
            throw new ForbiddenHttpException("Вам не разрешено редактировать данный пост");
        }

        $form = new BlogForm($blog);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($blog, $form);
                return $this->redirect(['/blog/view', 'category' => $blog->category->slug, 'post' => $blog->slug]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', [['Ошибка', $e->getMessage()]]);
            }
        }

        return $this->render('create', [
            'model' => $form,
            'blog' => $blog,
        ]);
    }
}