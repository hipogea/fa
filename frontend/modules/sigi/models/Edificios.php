<?php

namespace frontend\modules\sigi\models;
use common\models\masters\Trabajadores;
use frontend\modules\sigi\models\SigiUnidades;
use common\models\masters\Centros;
use Yii;

/**
 * This is the model class for table "{{%sigi_edificios}}".
 *
 * @property int $id
 * @property string $codtra
 * @property string $nombre
 * @property string $latitud
 * @property string $meridiano
 * @property string $proyectista
 * @property string $tipo
 * @property int $npisos
 * @property string $detalles
 * @property string $codcen
 * @property string $direccion
 * @property string $coddepa
 * @property string $codprov
 *
 * @property Trabajadores $codtra0
 * @property Centros $codcen0
 */
class Edificios extends \common\models\base\modelBase
{
   
    public $hardFields=['codigo','codcen'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_edificios}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtra', 'nombre','codigo', 'tipo', 'npisos', 'codcen', 'direccion', 'coddepa', 'codprov'], 'required'],
            [['npisos'], 'integer'],
            [['coddist','codigo'], 'safe'],
            [['detalles'], 'string'],
            [['codtra', 'codprov'], 'string', 'max' => 6],
            [['nombre', 'proyectista'], 'string', 'max' => 60],
            [['latitud', 'meridiano'], 'string', 'max' => 16],
            [['tipo'], 'string', 'max' => 3],
            [['codcen'], 'string', 'max' => 5],
            [['direccion'], 'string', 'max' => 100],
            [['coddepa'], 'string', 'max' => 9],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'codtra' => Yii::t('sigi.labels', 'Administrador'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'latitud' => Yii::t('sigi.labels', 'Latitud'),
            'meridiano' => Yii::t('sigi.labels', 'Meridiano'),
            'proyectista' => Yii::t('sigi.labels', 'Proyectista'),
            'tipo' => Yii::t('sigi.labels', 'Tipo Unidad'),
            'npisos' => Yii::t('sigi.labels', 'Niveles'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'codcen' => Yii::t('sigi.labels', 'Centro'),
            'direccion' => Yii::t('sigi.labels', 'Dirección'),
            'coddepa' => Yii::t('sigi.labels', 'Departamento'),
            'codprov' => Yii::t('sigi.labels', 'Provincia'),
             'coddist' => Yii::t('sigi.labels', 'Distrito'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentas()
    {
        return $this->hasMany(SigiCuentas::className(), ['edificio_id' => 'id']);
    }
    public function getCentro()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * {@inheritdoc}
     * @return EdificiosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EdificiosQuery(get_called_class());
    }
    
    private function queryUnidades(){
        return SigiUnidades::find()->where([
            '[[edificio_id]]'=>$this->id,
           // 'imputable'=>'1',
                ]);
    }
    private function queryUnidadesImputables(){
        return $this->queryUnidades()->andWhere([
             'imputable'=>'1',
                ]);
    }
    
    public function area(){
        if($this->isNewRecord)
        return 0;
        //var_dump($this->queryUnidades()->sum('[[area]]'));die();
        return $this->queryUnidadesImputables()->sum('[[area]]');
    }
    
    public function hasApoderados(){
      
      return(((SigiApoderados::find()->where(
              [
               'edificio_id'=>$this->id,
                
              ]
              )->count())>0)+0)?true:false;  
    }
    
    public function apoderados(){      
      return
        array_column(SigiApoderados::find()->where(
              [
               'edificio_id'=>$this->id,                
              ]
              )->asArray()->all(),'codpro');  
      }
      
   public static function treeBase(){
       $datos=static::find()->asArray()->all();
        $array_tree=[];
       foreach($datos as $fila){
         $keyTree='edi_'.$fila['id'];
         $array_tree[]=[             
                       'icon'=>'fa fa-building',
                       'title' => $fila['nombre'],
                       'lazy' => true ,
                       // 'OTHER'=>'holis',
                          'key'=>$keyTree,
             'children' => [
                        ['title' => yii::t('base.names','Unidades'),'tooltip'=>'fill-unidades_'.$fila['id'],'key'=>$keyTree.'_unidades','lazy'=>true],
                        ['title' => yii::t('base.names','Documentos'),'tooltip'=>'fill-documentos_'.$fila['id'],'key'=>$keyTree.'_documentos','lazy'=>true],
                        ['title' => yii::t('base.names','Colectores'),'tooltip'=>'fill-grupos_'.$fila['id'],'key'=>$keyTree.'_grupos','lazy'=>true],                                    
                    ],
                        ];
       }
       return $array_tree;
     
   }
   
   
   
   /***********
    * funcione s para verificar que la facturacion ya esta corecta
    * y que le deific esta listo 
    * para facturacion
    */
   
   /*Verifica que no falñta ningun departamentoi imputale 
    * le falte propietario 
    */
   public function facUnitsWithoutOwner(){
       /*Los departamentos que tienen por lo menis un propietario*/
       $idsWithOwner=SigiPropietarios::find()->select('[[unidad_id]]')->
               Where(['[[edificio_id]]'=>$this->id])->
       andWhere(['[[tipo]]'=> SigiUnidades::TYP_PROPIETARIO])->asArray()->all();
        $idsWithOwner= array_column($idsWithOwner, 'unidad_id');
       /*Los departamentos totoales 
        * 
        */
       return array_column(SigiUnidades::find()->select(['numero'])->
               where(['not in','id',$idsWithOwner])->
               all(),'numero');
   }
   
   
   /*Verifica que no falñta ningun medidor 
    * En cad adepartamento
    */
   public function facUnitsWithoutPoint($type){
       /*Los departamentos que tienen por lo menis un propietario*/
       $faltan=[];
      $idsTipo= array_column(SigiSuministros::find()->select('[[tipo]]')->distinct()->
         Where(['[[edificio_id]]'=>$this->id])->asArray()->all(),'tipo'); 
      if(count($idsTipo)==0){
          return ['all'=>['all']];
      }
     foreach($idsTipo as $tipo){
          $idsDepas= array_column(SigiSuministros::find()->select('[[unidad_id]]')->
               where(['[[edificio_id]]'=>$this->id,
                     ''=>$tipo,
                   ])->
               asArray()->all(),'unidad_id');
        $Noestan=array_column(SigiUnidades::find()->select(['numero'])->
               where(['not in','id',$idsDepas])->
               all(),'numero');
        if(count($Noestan)>0){
            $faltan[$tipo]=$Noestan;
        }
         
     }
     return $falta;
   }
     
       
      
}
