<h2><?=$title;?></h2>

<?=validation_errors();?>

<?=form_open('posts/update');?>
<input type="hidden" name="id" value="<?=$post['id']?>">
<div class="form-group">
    <label >Title</label>
    <input type="text" value="<?=$post['title'];?>" class="form-control" name="title" placeholder="Add title">
</div>
<div class="form-group">
    <label>Body</label>
    <textarea id="BlogEditor" class="form-control" name="body"  placeholder="Add post Details">
        <?=$post['body'];?>
    </textarea>
</div>
<div class="form-group">
    <label >Category</label>
    <select name="category_id" class="form-control">
        <?php foreach ($categories as $category):?>
            <option <?php if ($category['id']===$post['category_id']) echo "selected='selected'";?>
                    value="<?php echo $category['id'];?>"><?php echo $category['name'];?>
            </option>
        <?php endforeach;?>
    </select>

</div>
<button type="submit" class="btn btn-default">Submit</button>
<?=form_close();?>