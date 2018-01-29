<?php

namespace core\entities\User;


use core\components\Subscriber;
use core\entities\Recipe;
use core\entities\RecipeComment;
use core\entities\User\queries\UserQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property int $country_id [int(11)]
 * @property string $city
 * @property int $experience_id
 * @property string $about
 * @property string $avatar
 * @property string|array $subscribes
 * @property string $rate
 * @property int $status
 * @property int $recipes_count [int(11) unsigned]
 * @property string $email_confirm_token [varchar(255)]
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $avatarUrl
 * @property string $pageUrl
 * @property string $fullName
 *
 * @property RecipeComment[] $recipeComments
 * @property Recipe[] $recipes
 * @property Country $country
 * @property Experience $experience
 * @property Network[] $networks
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_WAIT = 1;
    const STATUS_ACTIVE = 10;

    const DEFAULT_EXPERIENCE = 1;

    public static function signupRequest($email, $password)
    {
        $user = new User();
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->experience_id = self::DEFAULT_EXPERIENCE;
        $user->status = self::STATUS_WAIT;
        $user->subscribes = Subscriber::DEFAULT_SUBSCRIBES;
        $user->email_confirm_token = Yii::$app->security->generateRandomString();
        return $user;
    }

    public function confirmSignup()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->email_confirm_token = null;
    }

    public static function signupByNetwork($network, $identity)
    {
        $user = new User();
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->subscribes = Subscriber::DEFAULT_SUBSCRIBES;
        $user->generateAuthKey();
        $user->experience_id = self::DEFAULT_EXPERIENCE;
        $user->networks = [Network::create($network, $identity)];
        return $user;
    }

    public function edit($username, $email, $countryId, $city, $about, array $subscribes)
    {
        $this->username = $username;
        $this->email = $email;
        $this->country_id = $countryId;
        $this->city = $city;
        $this->about = $about;
        $this->subscribes = $subscribes;
    }

    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return Yii::$app->params['frontendHostInfo'] . '/ava/' . $this->avatar;
        }
        return Yii::$app->params['frontendHostInfo'] . '/ava/empty.png';
    }

    public function saveAvatar(UploadedFile $file): void
    {
        try {
            $avatar = $this->id . '_' . time() . '.' . $file->extension;
            if ($file->saveAs(Yii::getAlias('@ava') . '/' . $avatar)) {
                Yii::$app->photoSaver->fitBySize(Yii::getAlias('@ava') . '/' . $avatar, 200, 200);
                if ($this->avatar != $avatar && is_file(Yii::getAlias('@ava') . '/' . $this->avatar)) {
                    unlink(Yii::getAlias('@ava') . '/' . $this->avatar);
                }
                $this->avatar = $avatar;
            } else {
                throw new \DomainException("Ошибка сохранения файла");
            }
        } catch (\Exception $e) {
            throw new \DomainException($e->getMessage());
        }
    }

    public function getPageUrl($absolute = false)
    {
        return $absolute ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl(['users/view', 'id' => $this->id]) :
            Url::to(['users/view', 'id' => $this->id]);
    }

    public function getFullName(): string
    {
        return $this->username ? Html::encode($this->username) : 'Неизвестный пользователь';
    }

    public function getSubscribeFor($id)
    {
        return ArrayHelper::getValue($this->subscribes, $id, 0);
    }

    public function afterFind()
    {
        $subscribes = Json::decode($this->subscribes);
        foreach (Subscriber::DEFAULT_SUBSCRIBES as $id => $value) {
            if (!isset($subscribes[$id])) {
                $subscribes[$id] = $value;
            }
        }
        $this->subscribes = $subscribes;
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->subscribes = Json::encode($this->subscribes);
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => ['networks'],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc

    public function rules()
    {
        return [
            [['email', 'experience_id', 'auth_key', 'password_hash'], 'required'],
            [['experience_id', 'recipes', 'rate', 'status'], 'integer'],
            [['about'], 'string'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['username', 'avatar'], 'string', 'max' => 50],
            [['country', 'city'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['experience_id'], 'exist', 'skipOnError' => true, 'targetClass' => Experience::className(), 'targetAttribute' => ['experience_id' => 'id']],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'username' => 'Username',
            'country' => 'Country',
            'city' => 'City',
            'experience_id' => 'Experience ID',
            'recipes' => 'Recipes',
            'about' => 'About',
            'avatar' => 'Avatar',
            'rate' => 'Rate',
            'status' => 'Status',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getRecipeComments(): ActiveQuery
    {
        return $this->hasMany(RecipeComment::className(), ['author_id' => 'id']);
    }

    public function getRecipes(): ActiveQuery
    {
        return $this->hasMany(Recipe::className(), ['author_id' => 'id']);
    }

    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getExperience(): ActiveQuery
    {
        return $this->hasOne(Experience::className(), ['id' => 'experience_id']);
    }

    public function getNetworks(): ActiveQuery
    {
        return $this->hasMany(Network::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->andWhere(['id' => $id])->active()->limit(1)->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->andWhere(['username' => $username])->active()->limit(1)->one();
    }

    /**
     * @param string $usernameOrEmail
     * @return null|static
     */
    public static function findByUsernameOrEmail($usernameOrEmail)
    {
        return static::find()
            ->andWhere([
                'or',
                ['username' => $usernameOrEmail],
                ['email' => $usernameOrEmail],
            ])
            ->active()
            ->one();
    }

    public static function findByNetworkIdentity($network, $identity)
    {
        return User::find()->joinWith('networks n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::find()
            ->andWhere(['password_reset_token' => $token])
            ->active()
            ->limit(1)
            ->one();
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
