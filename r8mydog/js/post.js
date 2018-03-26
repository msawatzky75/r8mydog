$(document).ready(
	function()
	{
		populateAllPosts();

		populateUsers();

		//update on value change
		// $('input').bind("input", updateResults);
		// $('input').change( updateResults);

		$("input[type='number']").bind("input", function(){

			var tempL = $("#ratingL").val();
			var tempH = $("#ratingH").val();

			if (tempL > tempH)
			{
				$("#ratingL").val(tempH);
				$("#ratingH").val(tempL);
			}

			if ($("#ratingL").val() == "")
			{
				$("#ratingL").val(0);
			}

		});

		//seacrh similar click
		$("#searchForm").on("submit", function(e) {
			e.preventDefault();
			console.dir($(this).serialize());
			updateResults();
		});
	}
);

//populates all the posts from the database
function populateAllPosts() {
	$.ajax({
		url: '/snippet/post.php',
		type: 'POST',
		data:
		{
			'postid': getUrlParameter('id') ? getUrlParameter('id') : 0,
			'userid': 0,
			'title': '',
			'ratingL': 0,
			'ratingH': 10,
			'sort': 'date',
			'desc': false
		},
		success: function(data, status) { $("#posts").html(data); }
	});
}

//gets values of the $_GET based on key
function getUrlParameter(sParam)
{
	var sPageURL = decodeURIComponent(window.location.search.substring(1));
	var sURLVariables = sPageURL.split('&');
	var sParameterName;

	for (var i = 0; i < sURLVariables.length; i++)
	{
		sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] === sParam)
		{
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
}

//updates the posts based on the values in the search form
function updateResults()
{
	//puts the posts into the #posts div in the document
		$.ajax({
			url: '/snippet/post.php',
			type: 'POST',
			data:
			{
				'postid': getUrlParameter('id') ? getUrlParameter('id') : 0,
				'userid': $('#users').val(),
				'title': $("#postTitle").val(),
				'ratingL': $("#ratingL").val() ? $("#ratingL").val() : 0,
				'ratingH': $('#ratingH').val() ? $('#ratingH').val() : 10,
				'sort': $('#sort').val(),
				'desc': $('#order').is(':checked')
			},
			success: function(data, status) { $("#posts").html(data); }
		});
}

//gets all the users in the database to populate the select list
function populateUsers() {
	var users = null;
	$.ajax({
		async: false,
		url: '/snippet/users.php',
		contentType: 'application/json;charset=utf-8;',
		dataType: 'json',
		type: 'POST',
		success: function(data) { users = data; }
	});
	users.forEach(function(element) {
		$('#userGroup').append($(document.createElement('option')).attr("value", element['userid']).text(element['fullname']));
	});
}
