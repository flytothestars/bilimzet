<?php $__env->startSection('content'); ?>
    <h2 class="mt-4 mb-3">Редактирование страниц сайта</h2>

<?php

require("classes/classes.php");
require("functions/functions.php");

  $db=new connect_db();
	   $sql="SET SQL_MODE = '';";
		$db->dbo->exec($sql);
		
////сохранение данных
if(isset($_REQUEST["pages_text"])) {
	
	$page_filt=$_REQUEST["page_filt"];
	$pages_text=$_REQUEST["pages_text"];
	
	$pages_text=$db->dbo->quote(base64_encode($pages_text));
	$page_filt=$db->dbo->quote($page_filt);
	
	$sql="UPDATE pages set content=$pages_text where page_filt=$page_filt";
	$db->dbo->exec($sql);
	echo "
	<script>
		alert('Данные страницы обновлены!');
	</script>
	";
}

////получение данных
if(isset($_REQUEST["page_filt"])) {
	
	
	$page_filt=$_REQUEST["page_filt"];
	
	$content="";
	$sql="SELECT content from pages where page_filt='".$page_filt."'";
				foreach ($db->dbo->query($sql) as $row){
					$content=base64_decode($row[0]);
				}
	
	
} else {
	
	$page_filt="footer";
	$content="";
	$sql="SELECT content from pages where page_filt='".$page_filt."'";
				foreach ($db->dbo->query($sql) as $row){
					$content=base64_decode($row[0]);
				}
}


?>

<form action="/admin/redakt" id='select_predmet_form' method='GET'>
<table>
<tr>
<td>
<select name="page_filt" onChange="document.getElementById('select_predmet_form').submit();">


		<option value="footer"  <?php if($page_filt=="footer") echo " selected";?> >Нижняя часть сайта, footer</option>
		<option value="contacts"  <?php if($page_filt=="contacts") echo " selected";?> >Страница контакты, общие, до формы отправки заявки</option>
		<option value="contacts_stuff"  <?php if($page_filt=="contacts_stuff") echo " selected";?> >Страница контакты, контакты сотрудников</option>
		<option value="about_text"  <?php if($page_filt=="about_text") echo " selected";?> >Страница О компании</option>
		<option value="about_text_main"  <?php if($page_filt=="about_text_main") echo " selected";?> >Главная, текст о Центре</option>
		
		
</select>
</td>
</tr>
</table>
</form>

 
     
  
    <link href="/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
   
 
		  <script src="/js/jquery-3.1.1.min.js"></script>
		  <script src="/js/jquery-2.1.1.js"></script>
    <script src="/js/bootstrap.min.js"></script>
	 <script src="/js/bootstrap.min.js"></script>
    <script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
   <script src="/js/plugins/sweetalert/sweetalert.min.js"></script>
	<!-- SUMMERNOTE -->
    <script src="/js/plugins/summernote/summernote.min.js"></script>


<!-- SUMMERNOTE -->
    <script src="/js/plugins/summernote/lang/summernote-ru-RU.js"></script>
    <script src="/js/plugins/summernote/lang/summernote-ru-RU.min.js"></script>

    <script>
        $(document).ready(function(){

            $('.summernote').summernote({
			  height: 500,   //set editable area's height
			  lang:'ru-RU'
			});

       });
    </script>
	<form action="/admin/redakt" id='update_page' method='POST'>
	<?php echo csrf_field(); ?> <!-- <?php echo e(csrf_field()); ?> -->
	<input type="hidden" name="page_filt" value="<?=$page_filt?>">
	<textarea class="summernote" name="pages_text" style="width:700px;height:550px"><?=$content?></textarea>
<br>

<input type="button" style="background-color:#1ab394;border-color:#1ab394;color:#FFFFFF;border-radius:3px;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;vertical-align:middle;width:330px;margin:0px;height:40px;cursor:pointer" onClick="document.getElementById('update_page').submit();" value="Сохранить Страницу">

</form>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OpenServer\domains\kcppk.loc\resources\views/admin/redakt.blade.php ENDPATH**/ ?>