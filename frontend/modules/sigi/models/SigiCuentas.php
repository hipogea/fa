<?php

namespace frontend\modules\sigi\models;
use common\models\masters\Bancos;
use common\models\masters\Monedas;
use common\models\masters\Clipro;
use Yii;

/**
 * This is the model class for table "{{%sigi_cuentas}}".
 *
 * @property int $id
 * @property string $tipo
 * @property string $codmon
 * @property string $codpro
 * @property string $nombre
 * @property string $numero
 * @property int $banco_id
 * @property int $edificio_id
 * @property string $detalles
 * @property string $indicaciones
 * @property string $indicaciones2
 *
 * @property Monedas $codmon0
 * @property SigiEdificios $edificio
 * @property Bancos $banco
 */
class SigiCuentas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_cuentas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'codmon',  'nombre', 'numero', 'banco_id', 'edificio_id'], 'required'],
            [['banco_id', 'edificio_id'], 'integer'],
            [['detalles', 'indicaciones', 'indicaciones2'], 'string'],
            [['tipo'], 'string', 'max' => 3],
            [['codmon'], 'string', 'max' => 5],
            [['codpro'], 'string', 'max' => 6],
            [['activa'], 'safe'],
            [['nombre'], 'string', 'max' => 60],
            [['numero'], 'string', 'max' => 100],
            [['codmon'], 'exist', 'skipOnError' => true, 'targetClass' => Monedas::className(), 'targetAttribute' => ['codmon' => 'codmon']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['banco_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bancos::className(), 'targetAttribute' => ['banco_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'tipo' => Yii::t('sigi.labels', 'Tipo'),
            'codmon' => Yii::t('sigi.labels', 'Moneda'),
            'codpro' => Yii::t('sigi.labels', 'Codpro'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'banco_id' => Yii::t('sigi.labels', 'Banco'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'indicaciones' => Yii::t('sigi.labels', 'Indicaciones'),
            'indicaciones2' => Yii::t('sigi.labels', 'Indicaciones2'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoneda()
    {
        return $this->hasOne(Monedas::className(), ['codmon' => 'codmon']);
    }
    
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanco()
    {
        return $this->hasOne(Bancos::className(), ['id' => 'banco_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiCuentasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiCuentasQuery(get_called_class());
    }
}
