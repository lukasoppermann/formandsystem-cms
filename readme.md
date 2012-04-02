# Form&System v2.0

## Database Structure

*CMS Tables*
- ci_sessions
- users
- log

- cms_data
- cms_entries
- cms_menu

- client_data
- client_entries
- client_menu
- client_files

### Table structure
*indexed colum*

**ci_sessions**
- session_id
- ip_address
- user_agent	
- last_activity
- user_data

**users**
- *id*
- token
- status
- *email*
- *user*
- password
- salt
- group	
- data

**log**
- *id*
- *user_id*
- *system*
- *type*
- *entry_id*
- date
- data

**cms_data**
- *id*
- *key*
- *type*
- value

**cms_menu**
- id
- label
- path
- type
- menu
- parent_id
- status
- position
- language
- data

**cms_entries**
- id
- *menu_id*
- *type*
- *language*
- *status*
- title
- text
- date
- data

## Config
- put to db
dir_media
dir_layout
dir_images
libs
css / _cache
js / _cache
- change prefix to db_prefix
- use data from cms data (incl. system/cms)