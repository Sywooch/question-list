<?php

namespace igribov\questionlist\models;

use Yii;
use igribov\questionlist\models\Model;
use yii\data\ActiveDataProvider;
use igribov\questionlist\models\AnswerList;

/**
 * AnswerListStatisticSearch represents the model behind the search form about `app\models\AnswerList`.
 */
class AnswerListStatisticSearch extends AnswerList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'question_list_id', 'do_id', 'scores'], 'integer'],
            [['date_from', 'date_to', 'status', 'list_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = AnswerList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'question_list_id' => $this->question_list_id,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'do_id' => $this->do_id,
            'scores' => $this->scores,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'list_name', $this->list_name]);

        return $dataProvider;
    }
}
