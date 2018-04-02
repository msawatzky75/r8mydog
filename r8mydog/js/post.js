const defaultPostNum = 12;
var posts;
$(document).ready(function()
	{
		//get all the posts
		$.ajax({
			async: false,//needed
			url: '/snippet/getPosts.php',
			dataType: 'json',
			type: 'POST',
			data:
			{
				'postid': 0,
				'userid': getUrlParameter('userid') ? getUrlParameter('userid') : 0,
				'title': '',
				'ratingL': 0,
				'ratingH': 10,
				'sort': 'epoch',
				'desc': true
			},
			success: function(data)
			{
				posts = _.filter(
					_.sortBy(data, [
						function(post) { return new Date() - new Date(post.epoch); },
						function (post) { return 10 - post.rating; }
						]
					),
					function (post)
					{
						return _.inRange(post.epoch, ((new Date()).setHours(0,0,0))/1000, ((new Date()).setHours(23,59,59))/1000);
					}
				);
			}
		});
		var pageNum = getUrlParameter("pageNum") ? getUrlParameter("pageNum") : 0;
		var postsToDisplay = getUrlParameter("posts") ? getUrlParameter("posts") : defaultPostNum;
		showPage(pageNum, postsToDisplay);
	}
);

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
function showPage(pageNum, postsToDisplay)
{
	setPagination(posts.length, pageNum, postsToDisplay);
	var workingPosts = _.chunk(_.sortBy(posts, function (post) { return 10 - post.rating; }), postsToDisplay)[pageNum - 1];
	if(workingPosts)
	{
		for(var post in workingPosts)
		{
			$.ajax({
				async: false,
				url: "/snippet/getPostCard-multi.php",
				type: "POST",
				data: workingPosts[post],
				success: function (data) { $("#posts").append(data); },
				error: function(xhr, textStatus, errorThrown) { console.dir(errorThrown); }
			});
		}
	}
	else
	{
		if (pageNum == 0)
			window.location.replace("?pageNum=1&posts=12");
		console.dir(pageNum);
	}
}

//sets the pagination nav
function setPagination(postsCount, pageNum, postsToDisplay)
{
	pageNum = parseInt(pageNum);
	var totalPages = Math.ceil(postsCount / postsToDisplay);
	var get = "";

	if (window.location.search.substring(1))
	{
		get = _.filter(window.location.search.substring(1).split("&"), function (str)
			{
				return !(str.split("=")[0] == "pageNum" || str.split("=")[0] == "posts");
			}
		).join("&");
		if (get)
		{
			get = "&"+get;
		}
	}

	$(".pagination-fill").append(`
		<li class="page-item `+ (pageNum == 1 ? 'disabled' : '') +`">
			<a class="page-link" href="`+("?pageNum="+(pageNum-1)+"&posts="+postsToDisplay+get)+`" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
				<span class="sr-only">Previous</span>
			</a>
		</li>`);

	var total = 7;//odd
	var leftCap = total/2 > pageNum ? 1 : pageNum < totalPages - total/2 ? pageNum - Math.floor(total/2) : totalPages - total + 1;
	var rightCap = total/2 > pageNum ? total : pageNum < totalPages - total/2 ? pageNum + Math.ceil(total/2) : totalPages + 1;
	if (leftCap <= 0)
	{
		leftCap = 1;
	}
	for (let i = leftCap; (i < rightCap) && (i < totalPages + 1); i++)
	{
		console.log(i);
		$(".pagination-fill").append(`<li class="page-item"><a class="page-link `+(i == pageNum ? "disabled" : "")+`" href="`+ ("?pageNum="+i+"&posts="+postsToDisplay+get) +`">`+i+`</a></li>`);
	}
	$(".pagination-fill").append(`
		<li class="page-item `+ (pageNum == totalPages ? 'disabled' : '') +`">
			<a class="page-link" href="`+("?pageNum="+(pageNum + 1)+"&posts="+postsToDisplay+get)+`" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
				<span class="sr-only">Next</span>
			</a>
		</li>`);
}
