<div id="entry_papers">
	<div id="entry_container" class='border-status-<?=$data['status']?>'>
		<?
		// open new form
		echo form_open(current_url(), array('id' => 'entry', 'class'=>'entry-form'));
			// check if Log exists
			if( isset($logs) && count($logs) > 0 )
			{
				// first log
				$tmp_log = $logs[key($logs)];
				$first_log = "<div data-id='".$tmp_log['id']."'>
								<span id='modified'>".date('d.m.Y, H:i',$tmp_log['date'])."</span> by <span id='editor'>".$tmp_log['data']['author']."</span>
							</div>";
				// list logs						
				foreach($logs as $date => $log)
				{
					$log_list[] = "<li data-id='".$log['id']."'><a href='#'>".str_replace(' ','&nbsp;',date('d.m.Y, H:i',$log['date'])." by ".$log['data']['author'])."</a></li>";
				}
				// create html for log
				$log = "<div id='log' class='icon edit-small'>".$first_log."<div id='log_list'><ul>".implode('',$log_list)."</ul></div></div>";
			}
			// top options
			echo "<div id='entry_form_top'>
					".variable($log)."
					<div id='top_options'><span id='publish' class='icon ".$visible."'></span></div>
				</div>";
			// hidden fields
			echo form_hidden(array(
				'entry_id' 	=> variable($id), 
				'menu_id' 	=> variable($menu_id)
			));
			// Header Images
			// check for existing image
			$system = $this->config->item('system');
			$class = 'empty';
			$_img = null;
			if(isset($data['title_image']) && isset($images))
			{
				$class = "empty full";
				$_img = '<img src="'.$system['config']['base'].$system['config']['media'].$images[$data['title_image']]['data']['path'].'" alt="'.variable($images[$data['title_image']]['data']['alt']).'" />';
				$title_img_id = $data['title_image'];
			}
			
			echo '<div id="header_images">';
				echo '<div id="header_image" class="'.$class.'" data-id="'.variable($title_img_id).'">';
				echo "<div class='options'>";
				if(variable($_img) != null )
				{
					echo "<span class='delete'>löschen</span>";
				}
				echo "<span class='add-gallery'>Galerie</span></div>";
				echo variable($_img);
				echo '<div id="file_uploader_header" class="file-uploader" data-url="'.$system['config']['base'].$system['config']['media'].'images/">       
					    <noscript>          
					        <p>Please enable JavaScript to use file uploader.</p>
					    </noscript>         
					</div></div>';
				// check for existing image
				$class = 'empty';
				$_img = null;
				if(isset($data['news_image']) && isset($images))
				{
					$class = "empty full";
					$_img = '<img src="'.$system['config']['base'].$system['config']['media'].$images[$data['news_image']]['data']['path'].'" alt="'.$images[$data['news_image']]['data']['alt'].'" />';
				}

				if($data['type'] != 2){ $class .= ' hidden'; }
				
				echo '<div id="news_image" class="'.$class.'">';
				echo variable($_img);
				echo '<div id="file_uploader_news" class="file-uploader" data-url="'.$system['config']['base'].$system['config']['media'].'images/">       
					    <noscript>          
					        <p>Please enable JavaScript to use file uploader.</p>
					    </noscript>         
					</div></div>';
			echo '</div>';
			// title input
			echo '<div id="title_box">';
				echo form_input(array(	'name'  		=> 'title',
		          						'id'    		=> 'title',
		          						'value' 		=> set_value('title',variable($title)),
										'placeholder' 	=> 'Titel des Eintrages',
										'class' 		=> 'input-hidden title'));
				// title tag input
				echo form_input(array(	'name'  		=> 'title_tag',
		          						'id'    		=> 'title_tag',
		          						'value' 		=> set_value('title_tag',variable($data['title_tag'])),
										'placeholder' 	=> '[Metatag] Titel des Eintrages',
										'class' 		=> 'input-hidden title-tag'));
			echo '</div>';
			// content textarea
			echo '<div class="form-element mceEditor">';
				echo form_textarea(array(	'name'  		=> 'text',
				          					'id'    		=> 'text',
				          					'value' 		=> set_value('text',variable($text)),
											'placeholder' 	=> 'Hier klicken um den Text hinzuzufügen',
											'class' 		=> 'input-hidden text wysiwyg'));
			echo '</div>';
			// tags textarea
			echo '<div class="form-element">';
				echo form_label('Tags (mit Komma getrennt eingeben)', 'tags', array('id' => 'tags_label', 'class' => 'icon tags'));
				echo form_textarea(array(	'name'  		=> 'tags',
			          						'id'    		=> 'tags',
			          						'value' 		=> set_value('tags',variable($data['tags'])),
											'placeholder' 	=> 'Tags mit Komma getrennt eingeben',
											'class' 		=> 'input-hidden tags'));
			echo '</div>';
			// excerpt textarea
			echo '<div class="form-element-half">';
				echo form_label('Auszug', 'excerpt', array('id' => 'label_excerpt'));
				echo form_textarea(array(	'name'  		=> 'excerpt',
			          						'id'    		=> 'excerpt',
			          						'value' 		=> set_value('excerpt',variable($data['excerpt'])),
											'placeholder' 	=> 'Auszug aus dem Artikel',
											'class' 		=> 'input-hidden half excerpt'));
			echo '</div>';
			// description textarea
			echo '<div class="form-element-half">';
				echo form_label('Kurzbeschreibung', 'description', array('id' => 'label_description'));
				echo form_textarea(array(	'name'  		=> 'description',
			          						'id'    		=> 'description',
			          						'value' 		=> set_value('description',variable($data['description'])),
											'placeholder' 	=> 'Kurzbeschreibung für Suchmaschinen',
											'class' 		=> 'input-hidden half description'));
			// robots options
				echo '<div id="robots">';
					echo form_label('Suchmaschinen Optionen', 'select_robots', array('class' => 'icon search'));
					echo $select['robots'];
				echo '</div>';
			echo '</div>';
			// downloads
			echo '<div class="form-element">';
				echo '<ul id="downloads">';
					echo '<lh>Downloads</lh>';
					echo '<li id="download_uploader" class="upload" data-url="'.$system['config']['base'].$system['config']['media'].'files/">
						<span class="label">Neue Datei Hochladen</span></li>';
					// add files if exist
					if(count(variable($downloads)) > 0)
					{
						foreach($downloads as $file)
						{
							echo '<li data-id="'.$file['id'].'" data-label="'.$file['data']['label'].'"><span class="label"><span class="icon text"></span>'.$file['data']['filename'].'</span><span class="size">'.byte_format($file['data']['size']).' ('.$file['data']['filetype'].')</span><span class="icon close-small"></span></li>';	
						}
					}
					//
				echo '</ul>';
			echo '</div>';
			// close form
			echo form_close();
		?>	
	</div>
</div>