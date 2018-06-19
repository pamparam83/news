<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\User;
use yii\helpers\ArrayHelper;
/**
 * UserSearch represents the model behind the search form of `core\entities\User`.
 */
class UserSearch extends User
{
    public $date_from;
    public $date_last;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username',  'email'], 'safe'],
            [['date_from', 'date_last'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()->alias('u');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'u.username', $this->username])
        ->andFilterWhere(['like', 'u.email', $this->email])
        ->andFilterWhere(['>=', 'u.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
        ->andFilterWhere(['<=', 'u.created_at', $this->date_from ? strtotime($this->date_from . ' 23:59:59') : null])
        ->andFilterWhere(['>=', 'u.updated_at', $this->date_last ? strtotime($this->date_last . ' 00:00:00') : null])
        ->andFilterWhere(['<=', 'u.updated_at', $this->date_last ? strtotime($this->date_last . ' 23:59:59') : null]);

        return $dataProvider;
    }

    public function rolesList()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}
