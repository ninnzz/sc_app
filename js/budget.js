$(document).ready(function(){
    str = "";
    for(i=0;i<service_list.length;i++){
      str += "<option value='"+service_list[i][0]+"'>"+service_list[i][1]+"</option>";
    }
    document.getElementById('input-domain-service').innerHTML = str;
    document.getElementById('input-activity-service').innerHTML = str;
});

function service_item(opt){

  sname  = document.getElementById('input-service-name');
  allocated  = document.getElementById('input-service-allocated');
  if(sname.value != ""){
    if($.trim(allocated.value) != "" && (allocated.value >=0 || allocated.value < 0)){
      document.getElementById('add-service-button').innerHTML = "Saving";
      document.getElementById('add-service-button').disabled = true;
      var form_data;
      var url = "";

      if(opt == 0){
        form_data = {
          alloted: allocated.value,
          sname: sname.value,
          reserved :0,
          in_order: 0,
          available: allocated.value,
          budget_level: "service"
        }
        url = "/budget/add_item";
      }

      /*******MAKING THE AJAX REQUEST*********/

      router.setMethod('post');
      router.setTargetUrl(url);
      router.setParams(form_data);
      events.setCurrentEvent("handle_input('service',data)");
      events.setErrorEvent("failed_input('service',data)");
      router.connect();

      /*******MAKING THE AJAX REQUEST*********/
    } else{
      alert("Enter a valid number"); 
    }
  } else{
    alert("Enter a valid name");
  }
}
function domain_item(opt){
  
  sname  = document.getElementById('input-domain-name');
  allocated  = document.getElementById('input-domain-allocated');
  service_id  = document.getElementById('input-domain-service');
  
  if(sname.value != ""){
    if($.trim(allocated.value) != "" && (allocated.value >=0 || allocated.value < 0)){
      document.getElementById('add-domain-button').innerHTML = "Saving";
      document.getElementById('add-domain-button').disabled = true;
      var form_data;
      var url = "";

      if(opt == 0){
        form_data = {
          alloted: allocated.value,
          dname: sname.value,
          reserved :0,
          in_order: 0,
          available: allocated.value,
          budget_level: "domain",
          service_id: service_id.value
        }
        url = "/budget/add_item";
      }

      /*******MAKING THE AJAX REQUEST*********/

      router.setMethod('post');
      router.setTargetUrl(url);
      router.setParams(form_data);
      events.setCurrentEvent("handle_input('domain',data)");
      events.setErrorEvent("failed_input('domain',data)");
      router.connect();

      /*******MAKING THE AJAX REQUEST*********/
    } else{
      alert("Enter a valid number"); 
    }
  } else{
    alert("Enter a valid name");
  }
}
function activity_item(opt){
  
  atitle  = document.getElementById('input-activity-title');
  acronym  = document.getElementById('input-activity-acronym');
  allocated  = document.getElementById('input-activity-allocated');
  color  = document.getElementById('input-activity-color');
  service_id  = document.getElementById('input-activity-service');
  domain_id  = document.getElementById('input-activity-domain');
  
  if(atitle.value != "" && acronym.value != "" && color.value != "" && domain_id.value != "" && service_id.value != ""){
    if($.trim(allocated.value) != "" && (allocated.value >=0 || allocated.value < 0)){
      document.getElementById('add-domain-button').innerHTML = "Saving";
      document.getElementById('add-domain-button').disabled = true;
      var form_data;
      var url = "";

      if(opt == 0){
        form_data = {
          alloted: allocated.value,
          title: atitle.value,
          acronym: acronym.value,
          color: color.value,
          reserved :0,
          in_order: 0,
          available: allocated.value,
          budget_level: "activity",
          service_id: service_id.value,
          domain_id: domain_id.value
        }
        url = "/budget/add_item";
      }

      /*******MAKING THE AJAX REQUEST*********/

      router.setMethod('post');
      router.setTargetUrl(url);
      router.setParams(form_data);
      events.setCurrentEvent("handle_input('domain',data)");
      events.setErrorEvent("failed_input('domain',data)");
      router.connect();

      /*******MAKING THE AJAX REQUEST*********/
    } else{
      alert("Enter a valid number"); 
    }
  } else{
    alert("Missing parameter");
  }
}

function handle_input(level, data){
  console.log(data);
  document.getElementById('add-'+level+'-button').innerHTML = "Changes Saved";
  document.getElementById('add-'+level+'-button').disabled = false;
  setTimeout(function(){
    document.getElementById('add-'+level+'-button').disabled = false;
    $('#'+level+'-add').modal('hide');
    if(level == "service"){
      opt = document.createElement('option');
      opt.innerHTML = data.data.name;
      opt.setAttribute("value",data.data.id);
      document.getElementById('input-domain-service').appendChild(opt);
      document.getElementById('input-activity-service').appendChild(opt);
      service_list.push([data.data.id,data.data.name]);

      document.getElementById('input-service-name').value='';
      document.getElementById('input-service-allocated').value='';
    } else if(level == "domain"){
      domain_list.push([data.data.id,data.data.name,data.data.service_id]);

      document.getElementById('input-domain-name').value='';
      document.getElementById('input-domain-allocated').value='';
    }

  },2000); 
}

function failed_input(level,data){
  console.log(data);
  document.getElementById('add-'+level+'-button').innerHTML = "Failed";
  document.getElementById('add-'+level+'-button').disabled = false;
}

function changeDomain(){
  service_id = document.getElementById('input-activity-service').value;
  str = "";
  for(i=0;i<domain_list.length;i++){
    if(service_id == domain_list[i][2]){
      str += "<option value='"+domain_list[i][0]+"'>"+domain_list[i][1]+"</option>";   
    }
  }
  document.getElementById('input-activity-domain').innerHTML = str;
}