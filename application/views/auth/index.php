<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header"><?php echo lang('index_heading');?></h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->
    	
    	<p><?php echo lang('index_subheading');?></p>
        
        <?php if($message) :?>
        <div class="alert alert-info" id="infoMessage"><?php echo $message;?></div>
    	<?php endif;?>

		<table class="table table-striped">
			<tr>
				<th><?php echo lang('index_fname_th');?></th>
				<th><?php echo lang('index_lname_th');?></th>
				<th><?php echo lang('index_email_th');?></th>
				<th><?php echo lang('index_groups_th');?></th>
				<th><?php echo lang('index_status_th');?></th>
				<th><?php echo lang('index_action_th');?></th>
			</tr>
			<?php foreach ($users as $user):?>
				<tr>
		            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
					<td>
						<?php foreach ($user->groups as $group):?>
							<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
		                <?php endforeach?>
					</td>
					<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
					<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
				</tr>
			<?php endforeach;?>
		</table>

		<p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> </p>

                        <!-- NÃO MEXER DAQUI PARA BAIXO -->
                    </div>
                </div>
            </div>
        </div>

<?php $this->load->view('template/rodape'); ?>