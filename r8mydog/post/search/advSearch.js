var posts;

$(document).ready(
	function()
	{
		populateUsers();
		updateResults();

		//set the high value if not set already
		$("input[type='number']").bind("input", function() {
			if (!$("#ratingH").val())
			{
				$("#ratingH").val(10);
			}
		});

		//seacrh similar click
		$("#searchForm").on("submit", function(e) {
			updateResults();
		});
	}
);

//updates the posts based on the values in the search form
function updateResults()
{
	var search =
	{
		'postid': get('id') ? get('id') : 0,
		'userid': $('#users').val(),
		'title': $("#postTitle").val(),
		'ratingL': parseInt(_.min([$("#ratingL").val(), $('#ratingH').val()]) ? _.min([$("#ratingL").val(), $('#ratingH').val()]) : 0),
		'ratingH': parseInt(_.max([$("#ratingL").val(), $('#ratingH').val()]) ? _.max([$("#ratingL").val(), $('#ratingH').val()]) : 10),
		'sort': $('#sort').val(),
		'desc': $('#order').is(':checked')
	};


	/*
	var workingPosts = _.filter(posts, function (post) {
		//return true/false to keep/discard
		var keep = true;
		if (keep && search.postid > 0)
		{
			keep = post.postid == search.postid;
		}
		if (keep && search.userid > 0)
		{
			keep = post.userid == search.userid;
		}
		if (keep && search.title != "")
		{
			keep = post.title == search.title;
		}
		if (keep)
		{
			//keep = (post.rating >=  && (post.rating <= _.max([search.ratingL, search.ratingH])));
			keep = _.inRange(post.rating, search.ratingL, search.ratingH);
		}
		return keep;
	});
	console.dir(workingPosts);
	*/

	$.ajax({
		async: false,//needed
		url: '../getPosts.php',
		dataType: 'json',
		type: 'POST',
		data: search,
		success: function(data) { posts = data; }
	});


	for (var post in posts)
	{
		console.log(post);
		$("#posts").html();
		$.ajax({
			async: false,
			url: "../getPostCard-multi.php",
			type: "POST",
			data: posts[post],
			success: function (data) { $("#posts").append(data); },
			error: function(xhr, textStatus, errorThrown) { console.dir(errorThrown); }
		});
	}
}

//gets all the users in the database to populate the select list
function populateUsers()
{
	var users = null;
	$.ajax({
		async: false,
		url: '/snippet/users.php',
		dataType: 'json',
		type: 'POST',
		success: function(data) { users = data; }
	});
	users.forEach(function(element) {
		$('#userGroup').append($(document.createElement('option')).attr("value", element['userid']).text(element['fullname']));
	});
}

//updates the posts based on the values in the search form
function showPage(posts, page, numPosts)
{
	setPagination(posts.length, page, numPosts);
	var workingPosts = _.chunk(_.sortBy(posts, function (post) { return 10 - post.rating; }), numPosts)[page - 1];
	if(workingPosts)
	{
		for(var post in workingPosts)
		{
			$.ajax({
				async: false,
				url: "getPostCard-multi.php",
				type: "POST",
				data: workingPosts[post],
				success: function (data) { $("#posts").append(data); },
				error: function(xhr, textStatus, errorThrown) { console.dir(errorThrown); }
			});
		}
	}
}

//sets the pagination nava
function setPagination(postsCount, page, numPosts)
{
	var totalPages = Math.ceil(postsCount / numPosts);
	var uidLink = userId ? "userid="+userId+"&" : "";
	var total = 7;//odd
	var leftCap = total/2 > page ? 1 : page < totalPages - total/2 ? page - Math.floor(total/2) : totalPages - total + 1;
	var rightCap = total/2 > page ? total : page < totalPages - total/2 ? page + Math.ceil(total/2) : totalPages + 1;
	if (leftCap <= 0) { leftCap = 1; }

	if (totalPages > 1)
	{
		$(".pagination-fill ul").append(
			`<li class="page-item `+ (page == 1 ? 'disabled' : '') +`">
				<a class="page-link" href="?`+(uidLink+"page="+(page-1)+"&posts="+numPosts)+`" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
					<span class="sr-only">Previous</span>
				</a>
			</li>`);
		for (let i = leftCap; (i < rightCap) && (i < totalPages + 1); i++)
		{
			$(".pagination-fill ul").append(`<li class="page-item"><a class="page-link `+(i == page ? "disabled" : "")+`" href="?`+ (uidLink+"page="+i+"&posts="+numPosts) +`">`+i+`</a></li>`);
		}
		$(".pagination-fill ul").append(
			`<li class="page-item `+ (page == totalPages ? 'disabled' : '') +`">
				<a class="page-link" href="?`+(uidLink+"page="+(page+1)+"&posts="+numPosts)+`" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
					<span class="sr-only">Next</span>
				</a>
			</li>`);
	}
	else
	{
		$(".pagination-fill").remove();
	}
}

//gets values of the $_GET based on key
function get(sParam)
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
