# skillup課題 SNSを作る

## DB
### User
* id int
* github_id string
* profile string nullable
* user_name string nullable

### Article
* article_id int
* github_id int
* favorite_github_id string nullable
* image text
* caption string nullable
* time time