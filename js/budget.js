$(document).ready(function(){
    str = "";
    for(i=0;i<service_list.length;i++){
      str += "<option value='"+service_list[i][0]+"'>"+service_list[i][1]+"</option>";
    }
    document.getElementById('input-domain-service').innerHTML = str;
    document.getElementById('input-activity-service').innerHTML = str;
    getItems('service');
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
  document.getElementById('add-'+level+'-button').innerHTML = "Changes Saved";
  document.getElementById('add-'+level+'-button').disabled = false;
  setTimeout(function(){
    document.getElementById('add-'+level+'-button').disabled = false;
    $('#'+level+'-add').modal('hide');
    if(level == "service"){
      opt = document.createElement('option');
      opt2 = document.createElement('option');
      opt.innerHTML = data.data.name;
      opt2.innerHTML = data.data.name;
      opt.setAttribute("value",data.data.id);
      opt2.setAttribute("value",data.data.id);
      document.getElementById('input-domain-service').appendChild(opt);
      document.getElementById('input-activity-service').appendChild(opt2);
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

function loadDomain(obj,service_id){
  var tmp = document.getElementById('ddown_button_'+service_id);
  tmp.disabled = true;
  tmp.innerHTML = "Loading";
  getItems('domain',service_id);
}

function loadActivity(obj,domain_id){
  var tmp = document.getElementById('adown_button_'+domain_id);
  tmp.disabled = true;
  tmp.innerHTML = "Loading";
  getItems('activity','',domain_id);
}

function getItems(typ,service_id,domain_id){
  var form_data;
  tp = false;
  
  if(typ == "service"){
    form_data = {
      budget_level: "service"
    }
    events.setCurrentEvent("handle_get('service',data)");
    tp = true;
  } else if(typ == "domain"){
    form_data = {
      budget_level: "domain",
      service_id: service_id
    }
    events.setCurrentEvent("handle_get('domain',data,'"+service_id+"')");
    tp = true;
  } else if(typ == "activity"){
    form_data = {
      budget_level: "activity",
      domain_id: domain_id
    }
    events.setCurrentEvent("handle_get('activity',data,'"+domain_id+"')");
    tp = true;
  }


  if(tp){
    /*******MAKING THE AJAX REQUEST*********/

    router.setMethod('get');
    router.setTargetUrl("/budget/get_item");
    router.setParams(form_data);
    events.setErrorEvent("failed_input('domain',data)");
    router.connect();

    /*******MAKING THE AJAX REQUEST*********/
  } else{
    alert("Invalid budget level..!");
  }
}

function handle_get(type,data,t_id){
  console.log(data);
  if(data.data instanceof Array && data.data.length > 0){
    for(i=0;i<data.data.length;i++){
      if(type == "service"){
        util.appender(templates.service_tmp(data.data[i]),'content-panel',1);     
      } else if(type == "domain"){
        var tmp = document.getElementById('ddown_button_'+t_id);
        tmp.disabled = false;
        tmp.innerHTML = "&#8595;";
        tmp.setAttribute("onclick","hide_elem(this,'"+'service_body_'+data.data[i].service_id+"',1)");
        util.appender(templates.domain_tmp(data.data[i]),'service_body_'+data.data[i].service_id,1);     
      } else if(type == "activity"){
        var tmp = document.getElementById('adown_button_'+t_id);
        tmp.disabled = false;
        tmp.innerHTML = "&#8595;";
        tmp.setAttribute("onclick","hide_elem(this,'"+'domain_body_'+data.data[i].domain_id+"',1)");
        util.appender(templates.activity_tmp(data.data[i]),'domain_body_'+data.data[i].domain_id,1);     
      }
    }
  } else{
    if(type == 'domain'){
      var tmp = document.getElementById('ddown_button_'+t_id);
      tmp.disabled = false;
      tmp.innerHTML = "&#8595;";
    } else if(type == "activity"){
      var tmp = document.getElementById('adown_button_'+t_id);
      tmp.disabled = false;
      tmp.innerHTML = "&#8595;";
    }
    alert("There's no data for this budget level yet....");
  }
}

function hide_elem(tmp,id,opt){
  if(opt == 1){
    document.getElementById(id).style.display = 'none';
    tmp.setAttribute("onclick","hide_elem(this,'"+id+"',0)");
  } else if(opt == 0){
    document.getElementById(id).style.display = 'block';
    tmp.setAttribute("onclick","hide_elem(this,'"+id+"',1)");
  }
}