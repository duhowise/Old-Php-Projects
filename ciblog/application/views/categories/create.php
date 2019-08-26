<h2><?=$title;?></h2>
<?=validation_errors();?>

<?=form_open_multipart('categories/create')?>
<div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" name="name" placeholder="Enter Department Name">
</div>
<button type="submit" class="btn btn-default">Save</button>
<?=form_close();?>
