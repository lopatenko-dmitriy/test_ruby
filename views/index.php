<?php
	$active_id = false;
	 if(isset($data['active_project']['id'])) { 
		$active_id = $data['active_project']['id'];
	 }
?>
<div class="h60"></div>
<div class="container">
  	<div class="row">
    	<div class="col-xs-12">
			<div class="panel panel-default">
				  <div class="panel-heading blue-heading"><h2>Проекты</h2></div>
				  <div class="panel-body">
					<div class="">
						<div class="row head-input">
							<div class="col-xs-12 col-md-1"><i class="fa fa-plus" aria-hidden="true"></i></div>
							<div class="col-xs-12 col-md-11">
								<div class="input-group">
								  <input type="text" placeholder="Название нового проекта" class="form-control new-project">
								  <span class="input-group-btn">
									<button class="btn btn-success" onclick="createProject()" type="button">Создать проект</button>
								  </span>
								</div>
								<div class="new-project-error"></div>
							</div>
						</div>
					</div>
					  <table class="table hover-table">
					  <?php if(!empty($data['projects'])){ 
								foreach($data['projects'] as $project) { ?>
									<tr data-id="<?=$project['id']?>" class="<?=($project['id'] == $active_id)? 'active_project' : ''?>">
										<td onclick="getTasks(<?=$project['id']?>)"><?=$project['id']?></td>
										<td onclick="getTasks(<?=$project['id']?>)"><?=$project['name']?></td>
										<td class="table-control">
											<i onclick="moveProject(<?=$project['id']?>, 'up')" class="fa fa-caret-square-o-up" aria-hidden="true"></i>
											<i onclick="moveProject(<?=$project['id']?>, 'down')"  class="fa fa-caret-square-o-down" aria-hidden="true"></i>
											<i onclick="editItem(<?=$project['id']?>, '<?=$project['name']?>', 'project')"  class="fa fa-pencil" aria-hidden="true"></i>
											<i onclick="removeItem(<?=$project['id']?>, 'project')"  class="fa fa-trash" aria-hidden="true"></i>
										</td>
									</tr>
					  <?php 
								}
							} else {
					   ?>
					   
							<h3>Нет проектов</h3>
						<?php } ?>
					  </table>
				  </div>
			</div>

		</div>
	</div>
	<?php if(isset($data['active_project']) && $data['active_project']) { ?>
	<div class="row all-tasks">
    	<div class="col-xs-12">
			<div class="panel panel-default">
				  <div class="panel-heading blue-heading"><h2>Задачи для проекта №<?=$data['active_project']['id']?> (<?=$data['active_project']['name']?>)</h2></div>
				  <div class="panel-body">
					<div class="">
						<div class="row head-input">
							<div class="col-xs-12 col-md-1"><i class="fa fa-plus" aria-hidden="true"></i></div>
							<div class="col-xs-12 col-md-11">
								<div class="input-group">
								  <input type="text" placeholder="Название новой задачи" class="form-control new-task">
								  <span class="input-group-btn">
									<button class="btn btn-success" onclick="createTask(<?=$data['active_project']['id']?>)" type="button">Создать задачу</button>
								  </span>
								</div>
								<div class="new-task-error"></div>
							</div>
						</div>
					</div>
					  <table class="table hover-table">
					  <?php if(!empty($data['tasks'])){ 
								foreach($data['tasks'] as $task) { ?>
									<tr>
										<td><?=$task['id']?></td>
										<td><?=$task['name']?></td>
										<td class="table-control">
											<i onclick="moveTask(<?=$task['id']?>, 'up', <?=$data['active_project']['id']?>)" class="fa fa-caret-square-o-up" aria-hidden="true"></i>
											<i onclick="moveTask(<?=$task['id']?>, 'down', <?=$data['active_project']['id']?>)"  class="fa fa-caret-square-o-down" aria-hidden="true"></i>
											<i onclick="editItem(<?=$task['id']?>,'<?=$task['name']?>', 'task')"  class="fa fa-pencil" aria-hidden="true"></i>
											<i onclick="removeItem(<?=$task['id']?>, 'task')"  class="fa fa-trash" aria-hidden="true"></i>
										</td>
									</tr>
					  <?php 
								}
							} else {
					   ?>
					   
							<h3>Нет задач</h3>
						<?php } ?>
					  </table>
				  </div>
			</div>

		</div>
	</div>
	<?php } ?>
</div>
 
