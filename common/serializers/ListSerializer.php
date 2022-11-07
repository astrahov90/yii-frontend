<?php

namespace common\serializers;

use common\models\Posts;
use Yii;
use yii\rest\Serializer;

class ListSerializer extends Serializer
{
    public function serialize($input)
    {
        if (is_array($input))
            return $input;

        $data = parent::serialize($input);

        if (array_key_exists('_meta',$data))
        {
            $meta = $data['_meta'];
            unset($data['_meta']);
            $data = array_merge($data, $meta);
        }

        unset($data['_links']);
        return $data;
    }
}