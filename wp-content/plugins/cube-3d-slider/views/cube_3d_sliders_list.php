<script>

		jQuery(document).ready(function(){

			jQuery('#cube-3d-sliders-list .remove').click(function(){
				var c3s = jQuery(this).parent('form').parent('.cube-3d-slider');
				jQuery.post(ajaxurl, {action: 'remove_c3s', id: jQuery(this).attr('rel'), _ajax_nonce: '<?= wp_create_nonce( "remove_c3s" ); ?>' }, function(){
					jQuery(c3s).remove();
				});
			});

			//choix d'une image dans la librairie Wordpress
		    jQuery('.form_c3s .choose_img').click(function(e) {
		    	var _this = this;
		        e.preventDefault();
		        var image = wp.media({ 
		            title: 'Upload Image',
		            // mutiple: true if you want to upload multiple files at once
		            multiple: false
		        }).open()
		        .on('select', function(e){
		            // This will return the selected image from the Media Uploader, the result is an object
		            var uploaded_image = image.state().get('selection').first();
		            // We convert uploaded_image to a JSON object to make accessing it easier
		            // Output to the console uploaded_image
		            var image_url = uploaded_image.toJSON().url;
		            // Let's assign the url value to the input field
		            jQuery('.form_c3s input[name='+jQuery(_this).attr('rel')+']').val(image_url);
		        });
		    });

		    //accordion pour les faces des cubes
		    jQuery('.form_c3s .accordion').accordion({ heightStyle: "content", collapsible: true, active: false });

		    //formulaire nouveau slider
		    jQuery('.add_new_c3s').click(function(){

		    	jQuery('#form_new_c3s').toggle('fast');

		    });

		});

</script>

<h2>All cube 3D sliders</h2>
<a href="#" class="add_new_c3s"><img src="<?php echo plugins_url( 'images/add.png', dirname(__FILE__) ) ?>" /> Add a new cube 3d slider</a><br />
<form action="" method="post" class="form_c3s" id="form_new_c3s">
	<?php wp_nonce_field( 'edit_c3s' ) ?>
	
	<label>Name: </label><input type="text" name="name" /><br />
	<label>Width: </label><input type="text" name="width" />px<br />
	<div class="accordion">
		<h3>Front face</h3>
		<div>
			<label>Front face image: </label><input type="text" name="front_face_image" /> <button class="choose_img" rel="front_face_image">Browser library</button><br />
			<label>Front face text: </label><?php echo wp_editor( '', 'front_face_text' ); ?>
		</div>
		<h3>Back face</h3>
		<div>
			<label>Back face image: </label><input type="text" name="back_face_image" /> <button class="choose_img" rel="back_face_image">Browser library</button><br />
			<label>Back face text: </label><?php echo wp_editor( '', 'back_face_text' ); ?>
		</div>
		<h3>Right face</h3>
		<div>
			<label>Right face image: </label><input type="text" name="right_face_image" /> <button class="choose_img" rel="right_face_image">Browser library</button><br />
			<label>Right face text: </label><?php echo wp_editor( '', 'right_face_text' ); ?>
		</div>
		<h3>Left face</h3>
		<div>
			<label>Left face image: </label><input type="text" name="left_face_image" /> <button class="choose_img" rel="left_face_image">Browser library</button><br />
			<label>Left face text: </label><?php echo wp_editor( '', 'left_face_text' ); ?>
		</div>
		<h3>Top face</h3>
		<div>
			<label>Top face image: </label><input type="text" name="top_face_image" /> <button class="choose_img" rel="top_face_image">Browser library</button><br />
			<label>Top face text: </label><?php echo wp_editor( '', 'top_face_text' ); ?>
		</div>
		<h3>Bottom face</h3>
		<div>
			<label>Bottom face image: </label><input type="text" name="bottom_face_image" /> <button class="choose_img" rel="bottom_face_image">Browser library</button><br />
			<label>Bottom face text: </label><?php echo wp_editor( '', 'bottom_face_text' ); ?>
		</div>
	</div>
	<input type="submit" value="Add cube 3d slider" />
</form>

<div id="cube-3d-sliders-list">
<?php

if(sizeof($cubes) > 0)
{
	foreach($cubes as $cube)
	{
		$cube->anim_axes = explode(',', $cube->anim_axes);
		echo '<div class="cube-3d-slider"><form action="" method="post" class="form_c3s">'.wp_nonce_field( 'update_c3s_'.$cube->id, "_wpnonce", true, false );
		echo '<label>Name : </label><input type="text" name="name" value="'.$cube->name.'" /><input type="hidden" name="id" value="'.$cube->id.'" /> <br />';
		echo '<label>Width : </label>';
		echo '<input type="text" name="width" value="'.$cube->width.'" />px<br />';
		echo '<div class="accordion">
			<h3>Front face</h3>
			<div>
				<label>Front face image: </label><input type="text" name="front_face_image" value="'.$cube->front_face_image.'" /> <button class="choose_img" rel="front_face_image">Browser library</button><br />
				<label>Front face text: </label>';
			wp_editor( $cube->front_face_text, 'front_face_text_'.$cube->id, array('textarea_name' => 'front_face_text')  );
			echo '</div>
			<h3>Back face</h3>
			<div>
				<label>Back face image: </label><input type="text" name="back_face_image" value="'.$cube->back_face_image.'" /> <button class="choose_img" rel="back_face_image">Browser library</button><br />
				<label>Back face text: </label>';
			wp_editor( $cube->back_face_text, 'back_face_text_'.$cube->id, array('textarea_name' => 'back_face_text')  );
			echo '</div>
			<h3>Right face</h3>
			<div>
				<label>Right face image: </label><input type="text" name="right_face_image" value="'.$cube->right_face_image.'" /> <button class="choose_img" rel="right_face_image">Browser library</button><br />
				<label>Right face text: </label>';
			wp_editor( $cube->right_face_text, 'right_face_text_'.$cube->id, array('textarea_name' => 'right_face_text')  );
			echo '</div>
			<h3>Left face</h3>
			<div>
				<label>Left face image: </label><input type="text" name="left_face_image" value="'.$cube->left_face_image.'" /> <button class="choose_img" rel="left_face_image">Browser library</button><br />
				<label>Left face text: </label>';
			wp_editor( $cube->left_face_text, 'left_face_text_'.$cube->id, array('textarea_name' => 'left_face_text') );
			echo '</div>
			<h3>Top face</h3>
			<div>
				<label>Top face image: </label><input type="text" name="top_face_image" value="'.$cube->top_face_image.'" /> <button class="choose_img" rel="top_face_image">Browser library</button><br />
				<label>Top face text: </label>';
			wp_editor( $cube->top_face_text, 'top_face_text_'.$cube->id, array('textarea_name' => 'top_face_text')  );
			echo '</div>
			<h3>Bottom face</h3>
			<div>
				<label>Bottom face image: </label><input type="text" name="bottom_face_image" value="'.$cube->bottom_face_image.'" /> <button class="choose_img" rel="bottom_face_image">Browser library</button><br />
				<label>Bottom face text: </label>';
			wp_editor( $cube->bottom_face_text, 'bottom_face_text_'.$cube->id, array('textarea_name' => 'bottom_face_text')  );
			echo '</div>
		</div>';
		echo '<input type="image" src="'.plugins_url( 'images/save.png', dirname(__FILE__) ).'" title="Save" />	
		<img title="Remove this cube 3d slider" class="remove action" rel="'.$cube->id.'" src="'.plugins_url( 'images/remove.png', dirname(__FILE__) ).'" />
		Shortcode : <i>[cube-3d-slider id='.$cube->id.']</i>
		</form>
		</div>';
	}
}
else
	echo '<p>No Cube 3D slider created yet !</p>';

?>
</div>

<h2>Need more options ? Look at <a href="http://www.info-d-74.com/produit/cube-3d-slider-pro-plugin-wordpress/" target="_blank">Cube 3D Slider Pro !</a></h2>