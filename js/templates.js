var templates = {

  service_tmp : function (data){
    var str;
    str = "<div class='col-s-12 col-md-12 m-cont' id='service_"+data.id+"'><div class='header' id='service_header_"+data.id+"'><button id='ddown_button_"+data.id+"' style='font-size:8px;' class='btn btn-danger btn-xs' onclick=\"loadDomain(this,'"+data.id+"')\">&#8595;</button>&nbsp;&nbsp;<em style='font-size:12px;' class='label label-primary label-large'>"+data.name+"</em><div style='float:right;width:500px;'  class='controls' id='service_controls_id'><em class='money-bar'>Alloted <span class='badge'>"+data.alloted+"</span></em><em class='money-bar'>In Order <span class='badge'>"+data.in_order+"</span></em><em class='money-bar'>Reserved <span class='badge'>"+data.reserved+"</span></em><em class='money-bar'>Available <span class='badge'>"+data.available+"</span></em></div></div><div class='row' id='service_body_"+data.id+"' style='display:block;'></div></div>";
    return str;
  },

  domain_tmp : function (data){
    var str;
    str = "<div class='col-s-12 col-md-12' id='domain_"+data.id+"' style='margin-top:5px;'><div class='domain_header' id='domain_header_"+data.id+"'><button id='adown_button_"+data.id+"' style='font-size:8px;margin-left:20px;' class='btn btn-danger btn-xs' onclick=\"loadActivity(this,'"+data.id+"')\">&#8595;</button>&nbsp;&nbsp;<h3 class='label label-success'>"+data.name+"</h3><div style='float:right;width:500px;'  class='controls' id='domain_controls_id'><em class='d-money-bar'>Alloted <span class='badge'>"+data.alloted+"</span></em><em class='d-money-bar'>In Order <span class='badge'>"+data.in_order+"</span></em><em class='d-money-bar'>Reserved <span class='badge'>"+data.reserved+"</span></em><em class='d-money-bar'>Available <span class='badge'>"+data.available+"</span></em></div></div><div class='row' id='domain_body_"+data.id+"'></div></div>";
    return str;

  },
  activity_tmp: function (data){
    var str;
    str = "<div class='col-s-12 col-md-12' id='activity_"+data.id+"' style='margin-top:5px;'><div class='activity_header' id='activity_header_"+data.id+"'><button style='font-size:8px;margin-left:30px;margin-right:5px;' class='btn btn-danger btn-xs' onclick='' >Edit</button><button style='font-size:8px;' class='btn btn-danger btn-xs' data-toggle='modal' href='#chart-modal'> Chart</button>&nbsp;&nbsp;<h3 class='label label-danger'>"+data.title+"</h3><div style='float:right;width:500px;'  class='controls' id='activity_controls_id'><em class='a-money-bar'>Alloted <span class='badge'>"+data.alloted+"</span></em><em class='a-money-bar'>In Order <span class='badge'>"+data.in_order+"</span></em><em class='a-money-bar'>Reserved <span class='badge'>"+data.reserved+"</span></em><em class='a-money-bar'>Available <span class='badge'>"+data.available+"</span></em></div></div><div class='row' id='activity_body_"+data.id+"'></div></div>";
    return str;
  }


}

var util = {
  appender : function(data,target,pos){
    if(data == '' || target == ''){
      return false;
    }
    prnt = document.getElementById(target);
    c_el = 'li';
    if(document.body.contains(prnt)){
      if(prnt.nodeName.toLowerCase() == 'ul'){
        c_el = 'li';
      } else if(prnt.nodeName.toLowerCase() == 'div'){
        c_el = 'div';
      }
    } else{
      return false;
    }   
    child = document.createElement(c_el);
    child.innerHTML = data;
    if(pos == 1){
      prnt.appendChild(child);
    } else if(pos == 0){
      prnt.insertBefore(child, prnt.firstChild);
    }
  },
  imageExist : function(url){
    var img = new Image();
      img.src = url;
      return img.height != 0;
  }
}