<?php
add_action( 'widgets_init', 'tle_postlists' );

function tle_postlists() {
	register_widget( 'tle_postlist' );
}

class tle_postlist extends WP_Widget {
	function tle_postlist() {
		$widget_ops = array( 'classname' => 'tle_postlist', 'description' => '显示热门文章' );
		$this->WP_Widget( 'tle_postlist', 'Tle-热门文章', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title        = apply_filters('widget_name', $instance['title']);
		$orderby      = $instance['orderby'];
		
		$args = array(
			'order'            => DESC,
			'orderby'          => $orderby,
			'showposts'        => 5,
			'caller_get_posts' => 1
		);
		query_posts($args);
		$html='';
		$html.='
			<section class="am-panel am-panel-default">
				<div class="am-panel-hd">'.$title.'</div>
				<ul class="am-list blog-list">
		';
		while (have_posts()){
			the_post();
			$html.='
				<li class="am-serif"><a href="'.get_permalink().'" title="'.the_title('','',false).'" target="_blank">'.the_title('','',false).'</a></li>
			';
		}
		wp_reset_query();
		$html.='
				</ul>
			</section>
		';
		echo $html;
	}

	function form( $instance ) {
?>
		<p>
			<label>
				标题：
				<input style="width:100%;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				排序：
				<select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
					<option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论数</option>
					<option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
					<option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机</option>
				</select>
			</label>
		</p>
	<?php
	}
}
?>