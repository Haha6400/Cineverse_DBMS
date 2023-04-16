<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('save_database'); ?>
				</div>
			</div>
			<div class="panel-body">
				<?php
					$user_id	=	$this->session->userdata('user_id');
					$user_detail = $this->db->get_where('user',array('user_id'=>$user_id))->row();
					?>
				<form method="post" action="<?php echo base_url();?>index.php?admin/backup" enctype="multipart/form-data">
					<input type="hidden" name="task" value="save_database" />

					<div class="form-group mb-3">
						<input type="submit" class="btn btn-success" value="Save database">
					</div>
				</form>
            </div>
        </div>
    </div>

	<div class="col-md-6">
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('restore'); ?>
				</div>
			</div>
			<div class="panel-body">

				<?php
					$user_id	=	$this->session->userdata('user_id');
					$user_detail = $this->db->get_where('user',array('user_id'=>$user_id))->row();
					?>
				<form method="post" action="<?php echo base_url();?>index.php?admin/backup" enctype="multipart/form-data">
					<input type="hidden" name="task" value="restore" />
					
					<div class="form-group mb-3">
	                    <label for="name">Database</label>
	                    <input type="file" class="form-control" name="databases">
	                </div>
					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Restore">
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
