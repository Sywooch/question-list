<?php

namespace app\modules\unicred\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\unicred\models\UsersOffices;

/**
 * UsersOfficesSearch represents the model behind the search form about `app\modules\unicred\models\UsersOffices`.
 */
class UsersOfficesSearch extends UsersOffices
{
    public $officeName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'office_id'], 'integer'],
            [['profile_id', 'profile_office_role','officeName'], 'safe'],
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
        $query = UsersOffices::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $sort = $dataProvider->getSort();
        $sort->attributes['officeName'] = [
            'asc' =>  ['office.name' => SORT_ASC],
            'desc' => ['office.name' => SORT_DESC],
            'label' => 'Office Name'
        ];
        $dataProvider->setSort($sort);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['office']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'profile_id', $this->profile_id])
            ->andFilterWhere(['like', 'profile_office_role', $this->profile_office_role]);

        $query->joinWith(['office'=>function($q) {
            $q->andFilterWhere(['like', 'office.name', $this->officeName]);
        }]);

        return $dataProvider;
    }
}
