<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Image;

/**
 * ImageModelSearch represents the model behind the search form of `app\models\image`.
 */
class ImageModelSearch extends Image
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id'], 'integer'],
            [['name', 'surname', 'file_name', 'photo_text'], 'safe'],
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
        $query = Image::find();

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
            'image_id' => $this->image_id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'surname', $this->surname])
            ->andFilterWhere(['ilike', 'file_name', $this->file_name])
            ->andFilterWhere(['ilike', 'photo_text', $this->photo_text]);

        return $dataProvider;
    }
}
