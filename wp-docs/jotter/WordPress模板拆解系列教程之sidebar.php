侧边栏常用到的模块

==========================================================
标签云
<?php wp_tag_cloud(); ?>
在主题模板中调用标签云,用以下代码即可轻松实现:
<?php wp_tag_cloud("smallest=10&largest=14&number=80"); ?>

修改字体大小,在functions.php中加入以下代码:
function rbt_tag_cloud_filter($args) {
$args = array(
"largest" => "20",
"smallest" => "10",
"number" => "50",
);
return $args;
}
add_filter("widget_tag_cloud_args", "rbt_tag_cloud_filter");

参数解释

    smallest:设置标签云中显示的所有标签中,计数最少(最少文章使用)的标签字体大小,默认值为 8pt 。
    largest:设置标签云的所有标签中,计数最多(最多文章使用)的标签的字体大小,默认值为22pt。
    unit:标签文字字号的单位,默认为pt,可以为px、em、pt、百分比等;
    number:设置标签云中显示的最多标签数量,默认值为45个,设置为”0″则调用所有标签;
    format:调用标签的格式,可选”flat”、”list”和”array”,默认为”flat”平铺,”list”为列表方式;
    separator:(字符串)(可选)标签之间的文本/空格。默认值:’/n’ (空格);
    orderby:设置标签云中标签的排序方式,默认值为”name”按名称排序。如果设置成”count”则按关联的文章数量排列;
    order:排序方式,默认为”ASC”按正序,”DESC”按倒序,”RAND”按任意顺序;
    exclude:排除部分标签,输入标签ID,并以逗号分隔,如”exclude=1,3,5,7″不显示ID为1、3、5、7的标签;
    include:包含标签,与exclude用法一样,作用相反,如”include=2,4,6,8″则只显示ID为2、4、6、8的标签;
    link:(字符串)(可选)设置链接,允许编辑某个指定标签。有效值包括:’view’ (默认值)、 ‘edit’ ;
    taxonomy:(字符串)(可选)用以生成云的分类法。’post_tag’将文章标签当作云的来源(默认值) 、’category’ 用文章分类生成云 、’link_category’用链接分类目录生成云;
    echo:(布尔型)(可选)显示结果,或将结果保留在变量中。默认值为true(显示标签云)。有效值包括:1 (true) 默认值 、0 (false) 。

注意：如果要用标签列表，可以把format设置为list,就会变成<ul><li>这种格式。
==========================================================
文章归档

<?php wp_get_archives(); ?>

==========================================================
友情链接

在3.5版本以后，友链功能默认是取消的；但link-manager.php等文件仍然存在的；如果你想启用,就在主题下的functions.php文件中添加如下代码：

 add_filter( "pre_option_link_manager_enabled", "__return_true" );

 前台调用:<?php wp_list_bookmarks("arguments"); ?>
==========================================================
WordPress随机文章:
<ul>
<?php
global $post;
$rand_posts = get_posts("numberposts=5&orderby=rand");
foreach( $rand_posts as $post ) :
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
</ul>

==========================================================
WordPress最新文章:
第一种方法:
<ul>
<?php
$new_posts = get_posts("numberposts=10");
foreach( $new_posts as $post ) :
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
</ul>

第二种方法:
<?php get_archives("postbypost", 10); ?> (显示10篇最新更新文章)

第三种方法:
<?php wp_get_archives(‘type=postbypost&limit=20&format=custom’); ?>
后面这个代码显示你博客中最新的20篇文章，其中format=custom这里主要用来自定义这份文章列表的显示样式。(fromat=custom也可以不要，默认以UL列表显示文章标题。)
==========================================================
wordpress纯代码实现相关文章:

TAG标签相关文章

同一TAG标签的文章，会显示出来

<ul class="relevant">
<?php
global $post;
$post_tags = wp_get_post_tags($post->ID);
if ($post_tags) {
foreach ($post_tags as $tag)
{
// 获取标签列表
$tag_list[] .= $tag->term_id;
}
// 随机获取标签列表中的一个标签
$post_tag = $tag_list[ mt_rand(0, count($tag_list) - 1) ];
$args = array(
"tag__in" => array($post_tag),
"category__not_in" => array(NULL), //若希望不包括某分类的文章，把NULL替换成该分类的ID，多个用逗号隔开
"post__not_in" => array($post->ID), //不显示当前文章
"showposts" => 4, // 显示相关文章数量
"caller_get_posts" => 1
);
query_posts($args);
if (have_posts()) :
while (have_posts()) : the_post(); update_post_caches($posts); ?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; else : ?>
<li>0篇相关文章</li>
<?php endif; wp_reset_query(); } ?>
</ul>

最后的判断语句是如果有相关文章，显示规则设置的文章，没有就显示 0篇相关文章
分类相关文章

获取同一分类下的文章作为相关文章

<ul class="relevant">
<?php
global $post;
$cats = wp_get_post_categories($post->ID); //获取当前文章的分类ID
if ($cats) {
$args = array(
"category__in" => array( $cats[0] ),
"post__not_in" => array( $post->ID ),
"showposts" => 6,
"caller_get_posts" => 1
);
query_posts($args);
if (have_posts()) :
while (have_posts()) : the_post(); update_post_caches($posts); ?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; else : ?>
<li>0篇相关文章</li>
<?php
endif;
wp_reset_query();
}
?>
</ul>

欢迎转载，但请保留原文地址 http://www.sjyhome.com/wordpress/wordpress-related-posts.html

==========================================================


==========================================================


==========================================================


==========================================================


==========================================================


==========================================================






