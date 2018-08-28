<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


$modelClass = $generator->modelClass;
$mn = explode('\\', $modelClass);
$modelName = array_pop($mn);
$model = new $modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}
if(method_exists($model, 'getTableColumnInfo') == false){
    exit('error, ' . get_class($model) . ' no getTableColumnInfo method. can not use common (..\..\vendor\yiisoft\yii2-gii\generators\crud\common) to generated.');
}
$tableColumnInfo = $model->getTableColumnInfo();
$controllerClass = $generator->controllerClass;
$controllerName = substr($controllerClass, 0, strlen($controllerClass) - 10);

?>

<?="<?php\n"?>
use yii\widgets\LinkPager;
use yii\base\Object;
use backend\components\widgets\ActiveForm;
use common\utils\CommonFun;
use yii\helpers\Url;

use <?=$modelClass?>;

?>

<?="<?php \$this->beginBlock('header');  ?>\n"?>
<!-- <head></head>中代码块 -->
<?="<?php \$this->endBlock(); ?>"?>
<div class="alert alert-warning alert-dismissible" style="display:none;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<p></p>
</div>

<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
                
    <div class="box-header">
        <h3 class="box-title"><?='<?=$model->isNewRecord ? "添加" : "修改" ?>'?></h3>
    </div>
    <!-- /.box-header -->
    
    <?='<?php $form = ActiveForm::begin(["id" => "'.Inflector::camel2id(StringHelper::basename($controllerName)).'-form", "layout"=>"horizontal"]); ?>'?>
    <div class="box-body">
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>

    </div>
    <div class="box-footer">
        <div class="form-group">
            <label class="col-sm-1 control-label"></label>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary">确定</button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?= "<?php ActiveForm::end(); ?>" ?>          
        
</div>
</div>
</div>
</section>

<?="<?php \$this->beginBlock('footer');  ?>\n"?>
<!-- <body></body>后代码块 -->
 <script>
$('#<?=Inflector::camel2id(StringHelper::basename($controllerName))?>-form').bind('submit', function(e) {
	e.preventDefault();
    $(this).ajaxSubmit({
    	type: "post",
    	dataType:"json",
    	success: function(value) 
    	{
        	if(value.errno == 0){
        		$("div.alert").fadeOut().fadeIn().removeClass('alert-warning').addClass('alert-success').find('p').html('操作成功');
                        setTimeout(function(){
                            $("div.alert").fadeOut();
                        },2000);
        		//window.location.reload();
        	}
        	else{
            	var json = value.data;
                var alertStr = '';
        		for(var key in json){
        			$('#<?=Inflector::camel2id(StringHelper::basename($controllerName))?>-' + key).attr({'data-placement':'top', 'data-content':json[key], 'data-toggle':'popover'}).addClass('popover-show').popover('show');
        			alertStr += json[key] + "<br/>";
        		}
                        $("div.alert").fadeOut().fadeIn().removeClass('alert-success').addClass('alert-warning ').find('p').html(alertStr);
        	}

    	}
    });
});

 
</script>
<?="<?php \$this->endBlock(); ?>"?>
