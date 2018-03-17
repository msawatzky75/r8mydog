# r8mydog Content Management System
This project is for non-profit use, a CMS rating site called **r8mydog**, where users post pictures of hotdogs that are rated by other users. I am making this for a friend who requested it for his personal use.

## Database
The database will use at least these three tables, more may be added as needed.

### Users
Table used to store the users and associated data.
Users can have 0 or more posts.
Users can have 0 or more ratings.

### Ratings
Table used to store the ratings written by a user on a specific post.
Ratings can only have 1 user.
Ratings can only have 1 post.

### Posts
Table used to store the image, title and post content to rate.
Posts can have only 1 user.
Posts can have 0 or more ratings.
