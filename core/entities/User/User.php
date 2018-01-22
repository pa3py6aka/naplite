<?php

namespace core\entities\User;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string $country
 * @property string $city
 * @property int $experience_id
 * @property int $recipes
 * @property string $about
 * @property string $avatar
 * @property string $rate
 * @property int $status
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
        $user->generateAuthKey();
        $user->experience_id = self::DEFAULT_EXPERIENCE;
        $user->networks = [Network::create($network, $identity)];
        return $user;
    }

    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return Yii::$app->params['frontendHostInfo'] . '/ava/' . $this->avatar;
        }
        return Yii::$app->params['frontendHostInfo'] . '/ava/empty.png';
    }

    public function getPageUrl($absolute = false)
    {
        return $absolute ?
            Yii::$app->frontendUrlManager->createAbsoluteUrl(['user/view', 'id' => $this->id]) :
            Url::to(['user/view', 'id' => $this->id]);
    }

    public function getFullName(): string
    {
        return $this->username ? Html::encode($this->username) : 'Неизвестный пользователь';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExperience()
    {
        return $this->hasOne(Experience::className(), ['id' => 'experience_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNetworks()
    {
        return $this->hasMany(Network::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
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
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param string $usernameOrEmail
     * @return null|static
     */
    public static function findByUsernameOrEmail($usernameOrEmail)
    {
        return static::find()->where([
            'and',
            [
                'or',
                ['username' => $usernameOrEmail],
                ['email' => $usernameOrEmail],
            ],
            ['status' => self::STATUS_ACTIVE]
        ])->one();
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

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
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
