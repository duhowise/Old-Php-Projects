<h2><?=$title?></h2>

<?php foreach ($posts as $post):?>
    <h3><?=$post['title'];?></h3>
    <div class="row">
        <div class="col-md-3">
            <img   src="<?=site_url()?>assets/images/posts/<?=$post['post_image']?>" alt="<?=$post['post_image']?>">
        </div>
        <div class="col-md-9">
            <small class="post-date">Posted On: <?=$post['createdat']?>  in <strong><?=$post['name']?></strong> </small><br>
            <p class="post-content"><?= word_limiter($post['body'],60);?></p><br>
            <p><a class="btn btn-default" href="<?=site_url('/posts/'.$post['slug'])?>">Read More</a></p>

        </div>
    </div>

<?php endforeach ?>



