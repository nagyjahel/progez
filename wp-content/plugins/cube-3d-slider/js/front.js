var faces = ['front', 'right', 'back', 'top', 'left', 'bottom'];

function change_face(slider, direction) {

	var classes = jQuery(slider).attr('class');

	classes = classes.split('-');

	var current = classes[classes.length-1];

	var i = 0, new_current = false;
	while(new_current === false)
	{
		if(faces[i] == current)
		{
			if(direction == 1) //next
			{
				new_current = i-1;
				if(new_current < 0)
					new_current = (faces.length-1);
			}
			else //prev
			{
				new_current = i+1;
				if(new_current >= faces.length)
					new_current = 0;
			}
		}
		i++;
	}

	jQuery(slider).attr('class', 'slider show-'+faces[new_current]);
}

jQuery(document).ready(function(){

	jQuery('.cube-3d-slider .prev').click(function(){

		var slider = jQuery(this).parent().find('.slider');

		change_face(slider, -1);

		return false;

	});

	jQuery('.cube-3d-slider .next').click(function(){

		var slider = jQuery(this).parent().find('.slider');

		change_face(slider, 1);

		return false;
	
	});

	//autoplay
	jQuery('.cube-3d-slider.autoplay').each(function(){

		var slider = jQuery(this).find('.slider');

		setInterval(function(){ change_face(slider, 1); }, 6000);

	});

});