		</div>
		<div id="edit-modal" class="modal fade">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Редактирование</h4>
			  </div>
			  <div class="modal-body">
					<div class="input-group">
					  <input type="text" class="form-control edit-name">
					  <input type="hidden" class="form-control edit-id">
					  <input type="hidden" class="form-control edit-type">
					  <span class="input-group-btn">
						<button class="btn btn-success" onclick="goEdit()" type="button">Сохранить изменения</button>
					  </span>
					</div>
					<div class="edit-error"></div>
			  </div>
			</div>
		  </div>
		</div>
      <hr>

      <footer>
        <div>&copy; Лопатенко Дмитрий 2016</div>
      </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/site/js/bootstrap.min.js"></script>
    <script src="/site/js/scripts.js"></script>
  </body>
</html>