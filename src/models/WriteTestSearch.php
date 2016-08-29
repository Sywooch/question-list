<?php

namespace igribov\questionlist\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * AnswerListSearch represents the model behind the search form about `igribov\questionlist\models\AnswerList`.
 */
class WriteTestSearch extends AnswerListSearch
{

     /**
     * @param $profile_id
     * @return array
     * Возвращает массив ID отделений, где пользователь является управляющим
     */
    protected function getOffiсeIds($profile_id)
    {
        $modelsUsersOffices = UsersOffices::findAll([
            'profile_id' => $profile_id,
            'profile_office_role' => 'manager'
        ]);
        return ArrayHelper::map($modelsUsersOffices, 'office_id', 'office_id');
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
        // берем ID отделений, где пользователь является управляющим, или где он назначен им.
        $officeIds = $this->getOffiсeIds(Yii::$app->user->identity->username);

        $query = AnswerList::find()->joinWith('questionList')->where(['do_id'=>$officeIds]);
        //$query = AnswerList::find()->innerJoinWith('questionList');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id'=>SORT_DESC
                ]
            ],
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

        $query->andFilterWhere([
            'questionlist_answer_list.id' => $this->id,
            'question_list_id' => $this->question_list_id,
            'scores' => $this->scores,
            /*'date_from' => $this->date_from,
            'date_to' => $this->date_to,*/
        ]);

        $query->andFilterWhere(['like', 'list_name', $this->list_name])
            ->andFilterWhere(['>=', 'date_from', $this->date_from])
            ->andFilterWhere(['<=', 'date_to', $this->date_to]);

        if($this->statusName) $query->andFilterWhere(['like', 'status', $this->statusName]);
        else $query->andFilterWhere(['not like', 'status', 'archive']);

        $query->joinWith(['office'=>function($q) {
            $q->andFilterWhere(['like', 'questionlist_office.name', $this->officeName]);
        }]);



        return $dataProvider;
    }
}
