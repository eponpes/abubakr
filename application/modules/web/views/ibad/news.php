<!--BLOG TITLE START-->
<section class="blogTitleSec">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="blogTitleList">
                    <h2>Blog</h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="blogCat">
                    <h6>Categories <i class="fa fa-bars"></i></h6>
                    <ul>
                        <li><a href="#">Web Desgin</a></li>
                        <li><a href="#">UI / UX</a></li>
                        <li><a href="#">Branding</a></li>
                        <li><a href="#">Development</a></li>
                        <li><a href="#">Mobile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--BLOG TITLE END-->

<!--BLOG CONTENT START-->
<section class="blogContents">
    <div class="container">
        <div class="row">
        <?php if(isset($news) && !empty($news)){ ?>
            <?php foreach($news AS $obj){ ?> 
            <div class="col-lg-4 col-sm-6 noPadding">
                <div class="singleBlog singleBlog2">
                    <div class="blogThumb">
                        <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                            <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $obj->image; ?>" alt="">
                        <?php }else{ ?>
                            <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                        <?php } ?>  
                    </div>
                    <div class="blogDec">
                        <div class="blogDate"><?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></div>
                        <h2 class="blogTitle"><a href="<?php echo site_url('news-detail/'.$obj->id); ?>"><?php echo $obj->title; ?></a></h2>
                        <div class="bperaDiv">
                            <p><?php echo strip_tags(substr($obj->news, 0, 180)); ?> ...</p>
                        </div>
                        <div class="blogBott">
                            <div class="bauthor">By<a href="#">Ihsan</a></div>
                            <div class="blogComs"><img src="images/comment.png" alt=""><a href="#">2 Comments</a></div>
                        </div>
                    </div>
                </div>
            </div>
                        <?php } } ?>
            <div class="clearfix"></div>
            <div class="col-lg-12">
                <div class="blogLoadmore text-center">
                    <a href="#" class="bes_button4">Load more</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--BLOG CONTENT END-->