//получить все задачи для проекта
function getTasks(active_project)
{
	$('body').css('opacity', '0.6');
	$.get('/', {active_project:active_project, ajax:1}, function(data){
		
		if(data){
			$('.container_main').html(data);
		} else {
			alert('Ошибка!')
		}
		$('body').css('opacity', '1');
		window.history.pushState(null, null, '?active_project=' + active_project);
	});
}

// перемещение проекта в соответствии с параметрами
function moveProject(id, move)
{
	$('body').css('opacity', '0.6');
	$.post('/index/moveproject', {id:id, move:move}, function(data){
		if(data){
			active_project = $('.active_project').attr('data-id');
			getTasks(active_project);
		} else {
			alert('Ошибка!')
		}
	});
}

// перемещение задачи в соответствии с параметрами
function moveTask(id, move, project_id)
{
	$('body').css('opacity', '0.6');
	$.post('/index/movetask', {id:id, move:move, project_id:project_id}, function(data){
		if(data){
			active_project = $('.active_project').attr('data-id');
			getTasks(active_project);
		} else {
			alert('Ошибка!')
		}
	});
}

// создание проекта
function createProject()
{
	var name = $('.new-project').val();
	if(name && name.length > 2){
		$.post('/index/createProject', {name:name}, function(data){
			if(data){
				active_project = $('.active_project').attr('data-id');
				getTasks(active_project);
			} else {
				alert('Ошибка!')
			}
		});
		
	} else  {
		$('.new-project').addClass('error');
		$('.new-project-error').text('Название должно содержать минимум 3-и символа');
	}
}

// создание задачи
function createTask(project_id)
{
	var name = $('.new-task').val();
	if(name && name.length > 2){
		$.post('/index/createTask', {name:name, project_id:project_id}, function(data){
			if(data){
				active_project = $('.active_project').attr('data-id');
				getTasks(active_project);
			} else {
				alert('Ошибка!')
			}
		});
		
	} else  {
		$('.new-task').addClass('error');
		$('.new-task-error').text('Название должно содержать минимум 3-и символа');
	}
}

// удаление проекта или задачи
function removeItem(id, type)
{
	$.post('/index/removeItem', {id:id, type:type}, function(data){
			if(data){
				active_project = $('.active_project').attr('data-id');
				getTasks(active_project);
			} else {
				alert('Ошибка!')
			}
		});
}

// открытвает попап с формой редактирования
function editItem(id, name, type)
{
	$('.edit-id').val(id);
	$('.edit-name').val(name);
	$('.edit-type').val(type);
	$('.edit-name').removeClass('error');
	$('.edit-error').text('');
    $("#edit-modal").modal('show');
}

// валидация и отправка на сервер изменений
function goEdit()
{
	var id = $('.edit-id').val();
	var name = $('.edit-name').val();
	var type = $('.edit-type').val();
	if(!name && name.length < 3){
		$('.edit-name').addClass('error');
		$('.edit-error').text('Название должно содержать минимум 3-и символа');
		return;
	}
    $("#edit-modal").modal('hide');
	if(id && name && type){
		$.post('/index/edit', {id:id, type:type, name:name}, function(data){
			if(data){
				active_project = $('.active_project').attr('data-id');
				getTasks(active_project);
			} else {
				alert('Ошибка!')
			}
		});
	}
}

// Drug&Drop задач
var dragEl = null;

function taskDragStart(e) {  
	$(e).css('opacity', '0.4');
	dragEl = e;
}

function taskDragOver(e) {
	  if (e.preventDefault) {
		e.preventDefault();
	  }
	  return false;
}

function taskDragEnter(e) {
	e.classList.add('over');
}

function taskDragLeave(e) {
	e.classList.remove('over');
}

function taskDrop(e) {
  if (dragEl != e) {
		var temp = $(dragEl).html();
		var id = $(dragEl).attr('data-id');
		$(dragEl).html($(e).html());
		$(dragEl).attr('data-id',$(e).attr('data-id'));
		$(e).html(temp);
		$(e).attr('data-id',id);

		$('.over').removeClass('over');
		$('.move').css('opacity', '1');
	  
		//  меняет местами задачи в бд
		var id1 = $(e).attr('data-id');
		var id2 = $(dragEl).attr('data-id');
		$.post('/index/changetask', {id1:id1, id2:id2}, function(data){
		});
  }
  return false;
}

function taskDragEnd(e) {
	$('.over').removeClass('over');
}

