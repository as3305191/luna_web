<style>
.file-drag-handle {
	display: none;
}
</style>
<!-- Widget ID (each widget will need unique ID)-->
<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
	<header>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.backTo()" class="btn btn-default ">
				<i class="fa fa-arrow-circle-left"></i>返回
			</a>
		</div>
		<div class="widget-toolbar pull-left">
			<a href="javascript:void(0);" id="back_parent" onclick="currentApp.doSubmit()" class="btn btn-default btn-danger">
				<i class="fa fa-save"></i>存檔
			</a>
		</div>
	</header>

	<!-- widget div-->
	<div>
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
			<input class="form-control" type="text">
		</div>
		<!-- end widget edit box -->

		<!-- widget content -->
		<div class="widget-body">

			<form id="app-edit-form" method="post" class="form-horizontal">
				<input type="hidden" name="id" id="item_id" value="<?= isset($item) ? $item -> id : '' ?>" />
				
				<fieldset>
					<div class="widget-toolbar pull-left">
						<label class="col-md-3 control-label">公告類別</label>
						<div class="col-md-6">
							<select id="news_style" class="form-control">
								<!-- option from javascript -->
							</select>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-sm btn-primary" id="add_news_style"><i class="fa fa-plus-circle fa-lg"></i></button>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">內容</label>
						<div class="col-md-6">
							<textarea required class="form-control" id="m_content" name="content"><?= isset($item) ? $item -> content : '' ?></textarea>
						</div>
					</div>
				</fieldset>
			</form>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>
<!-- end widget -->
<style>
	.kv-file-zoom {
		display: none;
	}
</style>
<script>
	$('#app-edit-form').bootstrapValidator({
		feedbackIcons : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		fields: {
		}
	})
	.bootstrapValidator('validate');
</script>

<style>
	.kv-file-zoom {
		display: none;
	}
	.cke_skin_v2 input.cke_dialog_ui_input_text, .cke_skin_v2 input.cke_dialog_ui_input_password {
	    background-color: white;
	    border: none;
	    padding: 0;
	    width: 100%;
	    height: 14px;
	    /* new lines */
	    position: relative;
	    z-index: 9999;
	}

</style>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?= base_url('js/plugin/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('js/plugin/ckeditor/adapters/jquery.js') ?>"></script>
<script type="text/javascript">
// ckeditor
var config = {
		plugins:'basicstyles,sourcearea,image,button,colorbutton,colordialog,contextmenu,toolbar,font,format,wysiwygarea,justify,menubutton,link,list',
		customConfig : '',
		toolbarCanCollapse : false,
		colorButton_enableMore : false,
		// removePlugins : 'list,indent,enterkey,showblocks,stylescombo,styles',
		extraPlugins : 'imagemaps,autogrow,uploadimage',
		autoGrow_onStartup : true,
		height:400,
		startupFocus: true,
		allowedContent: true
	}
	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,SelectAll,Scayt,About';

CKEDITOR.replace( "m_content", config);
CKEDITOR.instances['m_content'].on('change', function() { CKEDITOR.instances['m_content'].updateElement() });

$('#add_news_style').click(function() {
		layer.open({
			type:2,
			title:'',
			closeBtn:0,
			area:['400px','200px'],
			shadeClose:true,
			content:'<?=base_url('mgmt/news_edit/new_news_style')?>'
		})
	})

	function load_news_style() {
	$.ajax({
			url: '<?= base_url() ?>' + 'mgmt/news_edit/find_news_style',
			type: 'POST',
			data: {},
			dataType: 'json',
			success: function(d) {
				if(d) {
			
					$news_style = $('#news_style').empty();
					var option = '<option value="0">全部</option>';
          			$news_style.append(option);
					$.each(d.news_style, function(){
						$('<option/>', {
							'value': this.id,
							'text': this.news_style
						}).appendTo($news_style);
					});
				}
			},
			failure:function(){
				alert('faialure');
			}
		});

}
load_news_style();

</script>
