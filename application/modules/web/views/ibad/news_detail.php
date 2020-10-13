<?php /* <section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('news_detail'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="<?php echo site_url('news'); ?>"><?php echo $this->lang->line('news'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('news_detail'); ?></a></li>
        </ul>
    </div>
</section> */ ?>  
<!--BLOG BANNAR START-->
<section class="workDetailHead bdetail">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="wdhContent bdetail">
                    <h6><?php echo $this->lang->line('by'); ?> / <?php echo $news->name; ?></h6>
                    <h3><?php echo $news->title; ?></h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!--BLOG BANNAR END-->

<section class="featcureImage3">
    <div class="wdFeactureImage">
    <?php if(isset($news->image) && !empty($news->image)){ ?>
        <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $news->image; ?>" alt="">
    <?php }else{ ?>
        <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
    <?php } ?>
    </div>
</section>

<!--BLOG CONTENT START-->
<section class="commonSection">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="journal_wrap">
                    <div class="row">
                        <div class="col-sm-11">
                            <div class="singleJournal_meta">
                                <a class="jon_date" href="#"><?php echo date($this->global_setting->date_format, strtotime($news->date)); ?></a>
                                <a href="#">Umum</a>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <!--a class="jon_comment" href="#comment">2</a-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">                        
            <div class="col-md-8">
                <div class="journal_content">
                    <div class="row blogDescriptionTop">
                        <div class="col-md-12">
                            <p>
                            <?php echo $news->news; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="relatedProduct">
                    <h3 class="relatedTitle poppins">Related</h3>
                    <?php if(isset($latest_news) && !empty($latest_news)){ ?> 
                        <?php foreach($latest_news AS $obj ){ ?> 
                            <div class="relatedPost">
                                <div class="journalImgRela">
                                    <a href="<?php echo site_url('news-detail/'.$obj->id); ?>">
                                        <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $obj->image; ?>" alt="">
                                        <?php }else{ ?>
                                            <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                                        <?php } ?> 
                                    </a>
                                </div>
                                <div class="journalmeta relatedMeta">
                                    <a class="jnalDate" href="#"><?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></a>
                                    <a href="#">Umum</a>
                                </div>
                                <div class="j_contentRel">
                                    <h3 class="poppins"><?php echo $obj->title; ?></h3>
                                    <span class="authorName"><?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></span>
                                </div>
                            </div> 
                        <?php } ?>
                <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!--BLOG CONTENT END-->