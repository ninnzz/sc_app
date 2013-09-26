<?php
	$this->load->view('includes/header');

?>
<script type='text/javascript'>
 var service_list = [];
 var domain_list = [];
 <?php
    if(is_array($service_list)){
      foreach($service_list as $svc){
        echo "service_list.push(['".$svc['id']."','".$svc['name']."']);";
      }
    }
    if(is_array($domain_list)){
      foreach($domain_list as $dm){
        echo "domain_list.push(['".$dm['id']."','".$dm['name']."','".$dm['service_id']."']);";
      }
    }
 ?>;
</script>
<style>
  #container{
    margin-top:80px;
  }
</style>
<div id='container' class='container'>
		<?php
			if(isset($response->message)){
		?>
			<div class='alert'>
				<?php
					echo $response->message;
				?>
			</div>
		<?php } ?>
  <div id='budget-div' class='row' style='width:100%;'>
    <div class='col-s-12 col-md-8'>
      <div class='row' id='control-panel'>
        <div style='float:left;margin-left:10px;'>
          <button class='btn btn-info btn-xs' data-toggle="modal" href="#service-add">Add Service</button>
          <button class='btn btn-success btn-xs' data-toggle="modal" href="#domain-add">Add Domain</button>
          <button  class='btn btn-danger btn-xs' data-toggle="modal" href="#activity-add">Add Activity</button>
        </div>
        <div style='float:right;'>
          <span class="label label-default">Sort View</span>
          <button class='btn btn-info btn-xs'>Service</button>
          <button class='btn btn-success btn-xs'>Domain</button>
          <button  class='btn btn-danger btn-xs'>Activity</button>
        </div>
      </div>
      <div class='row' id='content-panel'>

      </div>
    </div>
  
    <div id ='stats' class='col-s-12 col-md-4'>
  
    </div>
  </div> 
</div>
<div id='service-add' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="sAddModal" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Service</h4>
        </div>
        <div class="modal-body">
          <span class='label label-primary'>Service Name</span>
          <input type='text' id='input-service-name' class='form-control' style='margin-top:10px;margin-bottom:10px;'/>
          <span class='label label-primary'>Allocated</span>
          <input type='text' id='input-service-allocated' class='form-control' style='margin-top:10px;margin-bottom:10px;'/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id='add-service-button' type="button" class="btn btn-primary" onclick='service_item(0)'>Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id='domain-add'  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dAddModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Domain</h4>
        </div>
        <div class="modal-body">
          <span class='label label-success'>Domain Name</span>
          <input type='text' id='input-domain-name' class='form-control' style='margin-top:10px;margin-bottom:10px;'/>
          <span class='label label-success'>Service Name</span>
          <select class='form-control' id='input-domain-service' style='margin-top:10px;margin-bottom:10px;'>
          </select>
          
          <span class='label label-success'>Allocated</span>
          <input type='text' id='input-domain-allocated' class='form-control' style='margin-top:10px;margin-bottom:10px;'/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="add-domain-button" class="btn btn-primary" onclick='domain_item(0)'>Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id='activity-add'  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="aAddModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Activity</h4>
      </div>
      <div class="modal-body">
        <span class='label label-danger'>Activity Title</span>
        <input type='text' id='input-activity-title' class='form-control' style='margin-top:10px;margin-bottom:10px;'/>
        <span class='label label-danger'>Acronym</span>
        <input type='text' id='input-activity-acronym' class='form-control' style='margin-top:10px;margin-bottom:10px;'/>
        <span class='label label-danger'>Service</span>
        <select class='form-control' onchange='changeDomain()' id='input-activity-service' style='margin-top:10px;margin-bottom:10px;'>
        </select>
        <span class='label label-danger'>Domain</span>
        <select class='form-control' id='input-activity-domain' style='margin-top:10px;margin-bottom:10px;'>
        </select>
        <span class='label label-danger'>Allocated</span>
        <input type='text' id='input-activity-allocated' class='form-control' style='margin-top:10px;margin-bottom:10px;'/>
        <span class='label label-danger'>Color</span>
        <input type='text' id='input-activity-color' readonly class='color form-control' style='margin-top:10px;margin-bottom:10px;'/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="add-activity-button" class="btn btn-primary" onclick='activity_item(0)'>Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script type='text/javascript' src='/js/budget.js'></script>

<?php
  $this->load->view('includes/footer');
?>