const DEFAULT_POST_COUNT = 12;
var page;
var numPosts;
var postId;
var userId;
var posts;

$(document).ready(function()
	{
		//php makes sure the get exists
		page = parseInt(get("page"));
		numPosts = parseInt(get("posts"));
		postId = parseInt(get("id"));
		userId = parseInt(get("userid"));

		//get all the posts
		$.ajax({
			async: false,//needed
			url: 'getPosts.php',
			dataType: 'json',
			type: 'POST',
			data:
			{
				'postid': 0,
				'userid': get('userid') ? get('userid') : 0,
				'title': '',
				'ratingL': 0,
				'ratingH': 10,
				'sort': 'epoch',
				'desc': true
			},
			success: function(data)
			{
				posts =
					_.sortBy(data, [
						function(post) { return new Date() - new Date(post.epoch); },
						function (post) { return 10 - post.rating; }
						]
					);
			}
		});

		var todaysPosts = _.filter(posts,
							function (post)
							{
								return _.inRange(post.epoch, ((new Date()).setHours(0,0,0))/1000, ((new Date()).setHours(23,59,59))/1000);
							}
						);

		if (postId)
		{
			var post = _.find(posts, function (post) { return post.postid == postId; });
			if (post)
			{
				$("head title").html(post.title + " - r8mydog");
				$.ajax({
					async: false,
					url: "getPostPage.php",
					type: "POST",
					data: post,
					success: function (data) { $("#post").append(data); },
					error: function(xhr, textStatus, errorThrown) { console.dir([xhr, textStatus, errorThrown]); }
				});
				//fill comments
			}
		}
		else if (userId)
		{
			var userPosts = _.filter(posts, function(post) { return post.userid == userId; });
			if (userPosts.length)
			{
				var name = userPosts[0].fname;
				$("head title").html(name+"'s Posts - r8mydog");
				showPage(userPosts, page, numPosts);
			}
			else {
				console.log("no posts");
			}
		}
		else if (todaysPosts.length)
		{
			$("head title").html("Today's Posts - r8mydog");
			showPage(todaysPosts, page, numPosts);
		}
		else if (posts.length)
		{
			$("head title").html("Top's Posts - r8mydog");
			showPage(posts, page, numPosts);
		}
		else
		{
			$("head title").html("No Posts - r8mydog");
		}
	}
);

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
