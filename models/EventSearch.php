<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Event;

/**
 * EventSearch represents the model behind the search form of `app\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uid'], 'integer'],
            [['name', 'start_at', 'end_at', 'created_at', 'updater_at'], 'safe'],
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
        $query = Event::find();
        $query->cache(3600);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'created_at' => $this->created_at,
            'updater_at' => $this->updater_at,
            'uid' => $this->uid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->leftJoin(['access' => 'access'], 'event.id = access.eventid');
        $query->andWhere(
            [
                'or',
                ['uid' => \Yii::$app->user->getId()],
                ['access.userid' => \Yii::$app->user->getId()],    
            ]
        );

        return $dataProvider;
    }
}
