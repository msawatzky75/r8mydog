$(document).ready(function ()
{
	$("#dogImgControl").change(function()
	{
			readURL(this);
	});
});

function readURL(input)
{
	if (input.files && input.files[0])
	{
			var reader = new FileReader();

			reader.onload = function (e)
			{
				$('#dogImgPreview').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
	}
}
