<?php

namespace app\modules\unicred\questionlist\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\unicred\questionlist\models\AnswerList;

/**
 * AnswerListSearch represents the model behind the search form about `app\modules\unicred\questionlist\models\AnswerList`.
 */
class AnswerListSearch extends AnswerList
{
    public $officeName;
    public $statusName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'question_list_id', 'do_id'], 'integer'],
            [['date_from', 'date_to','date','status','officeName','statusName'], 'safe'],
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
        $sort = $dataProvider->getSort();
        $sort->attributes['officeName'] = [
            'asc' =>  ['questionlist_office.name' => SORT_ASC],
            'desc' => ['questionlist_office.name' => SORT_DESC],
            'label' => 'Отделение'
        ];
        $sort->attributes['statusName'] = [
            'asc' =>  ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
            'label' => 'Статус'
        ];

        $dataProvider->setSort($sort);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['questionlist_office']);
            return $dataProvider;
        }
        $query->joinWith('questionList');

        $query->andFilterWhere([
            'id' => $this->id,
            'question_list_id' => $this->question_list_id,
            'scores' => $this->scores,
            'date' => $this->date,
            /*'date_from' => $this->date_from,
            'date_to' => $this->date_to,*/
        ]);

        $query
            //->andFilterWhere(['like', 'list_name', $this->list_name])
            ->andFilterWhere(['>=', 'date_from', $this->date_from])
            ->andFilterWhere(['<=', 'date_to', $this->date_to]);

        if(!$this->statusName ) $query->andFilterWhere(['not like', 'status', 'archive' ]);
        else  $query->andFilterWhere(['like', 'status', $this->statusName ]);

        $query->joinWith(['office'=>function($q) {
            $q->andFilterWhere(['like', 'questionlist_office.name', $this->officeName]);
        }]);

        return $dataProvider;
    }
}
