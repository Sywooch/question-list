<?php

namespace app\modules\unicred\questionlist\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\unicred\questionlist\models\UsersOffices;

/**
 * UsersOfficesSearch represents the model behind the search form about `app\modules\unicred\questionlist\models\UsersOffices`.
 */
class ManagersSearch extends UsersOffices
{
    public $officeName;
    public $regionName;
    public $roleName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'office_id'], 'integer'],
            [['profile_id', 'profile_office_role','officeName','roleName','regionName'], 'safe'],
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
            'asc' =>  ['questionlist_office.name' => SORT_ASC],
            'desc' => ['questionlist_office.name' => SORT_DESC],
            'label' => 'Имя офиса'
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
            'id' => $this->id,
        ]);

        if($this->roleName) {
            $this->profile_office_role = $this->roleName;
        }

        $query->andFilterWhere(['like', 'profile_id', $this->profile_id])
            ->andFilterWhere(['like', 'profile_office_role', 'manager']);

        $query->joinWith(['office'=>function($q) {
            $q->andFilterWhere(['like', 'questionlist_office.name', $this->officeName]);
        }]);

        $query->joinWith(['region'=>function($q) {
            $q->andFilterWhere(['like', 'questionlist_region.name', $this->regionName]);
        }]);

        return $dataProvider;
    }
}
