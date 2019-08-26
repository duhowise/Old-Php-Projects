<h2><?=$post['title'];?></h2>
<small class="post-date">Posted On: <?=$post['createdat']?> in <strong><?=$post['name']?></strong></small><br>
<div >
    <img  class="pull-left view-image"  src="<?=site_url()?>assets/images/posts/<?=$post['post_image']?>" alt="<?=$post['post_image']?>">
    <?=$post['body']?>
</div>
<hr>
<a href="<?=base_url()?>posts/edit/<?=$post['slug'];?>" class="btn btn-default pull-left">Edit</a>
<?=form_open('/posts/delete/'.$post['slug']);?>
<input type="submit" value="delete" class="btn btn-danger" >
</form>
