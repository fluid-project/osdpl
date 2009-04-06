// $Id: taxonomy_fields.js,v 1.1 2008/03/12 11:00:39 boneless Exp $

var req;
var voc_id;

function check_browser() {
  req = false;
  if(window.XMLHttpRequest) {
    try {
      req = new XMLHttpRequest();
    } catch(e) {
      req = false;
    }
  }
  else if(window.ActiveXObject) {
    try {
      req = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {
        req = new ActiveXObject("Microsoft.XMLHTTP");
      } catch(e) {
        req = false;
      }
    }	
  }
  return req;
}

function insert_terms(){
	var voc = document.getElementById('edit-voc-sel');
	document.getElementById('voc_enable').innerHTML = '';
	document.getElementById('voc_enable').className = 'taxonomy_fields_loading';
	if(document.getElementById('terms')){
	  document.getElementById('terms').innerHTML = '';	
	}
	if(document.getElementById('term_details')){
	  document.getElementById('term_details').innerHTML = '';
	}
    
	var vid = voc.options[voc.selectedIndex].value;
	req = check_browser();  
	if(req) {		
	     req.onreadystatechange = insert_terms_html;
         req.open("POST", "?q=admin/content/taxonomy_fields/ajax", true);
	     param="op=get_terms&vid="+vid;
	     req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	     req.setRequestHeader("Content-length", param.length);
	     req.setRequestHeader("Connection", "close");
	     req.send(param);
	} 	
}


function insert_terms_html() {
	if (req.readyState == 4 && req.status == 200 && req.responseXML !== null){	
		var vocabularies = req.responseXML.getElementsByTagName( 'vocabulary' );
		var vocabulary = vocabularies.item(0);
		if(vocabulary.getAttribute("voc_enable")){
		  var voc_enable = vocabulary.getAttribute("voc_enable"); 
		}
		if(vocabulary.getAttribute("vid")){
		  var vid = vocabulary.getAttribute("vid");
		} 
		if (voc_enable !== ""){
			if(vid == "0"){
              document.getElementById('voc_enable').innerHTML = '';
            }
			else if(voc_enable == "1"){
				document.getElementById('voc_enable').innerHTML = '';
				document.getElementById('voc_enable').innerHTML += '<div class="form-item"><p>Should this vocabulary carry fields?</p><div class="form-radios">';
				document.getElementById('voc_enable').innerHTML += '<label class="option"><input type="radio" name="voc_enable" value="0" class="form-radio" /> Disabled</label></div>';
 				document.getElementById('voc_enable').innerHTML += '<div class="form-item"><label class="option"><input type="radio" name="voc_enable" value="1"  checked="checked"  class="form-radio" /> Enabled</label>';
				document.getElementById('voc_enable').innerHTML += '</div></div>';
			}
			else {
				document.getElementById('voc_enable').innerHTML = '';
				document.getElementById('voc_enable').innerHTML += '<div class="form-item"><p>Should this vocabulary carry fields?</p><div class="form-radios">';
				document.getElementById('voc_enable').innerHTML += '<label class="option"><input type="radio" name="voc_enable" value="0"  checked="checked"  class="form-radio"/> Disabled</label></div>';
 				document.getElementById('voc_enable').innerHTML += '<div class="form-item"><label class="option"><input type="radio" name="voc_enable" value="1" class="form-radio" /> Enabled</label>';
				document.getElementById('voc_enable').innerHTML += '</div></div>';
			}
		}
		else {
			document.getElementById('voc_enable').innerHTML = "";
		}
		var term_list = req.responseXML.getElementsByTagName( 'term' );
        if(term_list){
		  	if (term_list.item(0) !== "" && term_list.item(0) !== null){
		  		var txt = '';	  		
		  		txt += '<b>Term:</b><br />';
			  	txt += '<select id="sel_term" name="sel_term" onchange="insert_term_detail()">';			
				txt += "<option value='select' selected='selected'>Select Term<\/option>";
			  	 
			  	for( var i = 0; i < term_list.length; i++ )
			    {		    
			      var term = term_list.item( i );
			      var tid = term.getAttribute( 'tid' ).toString();
			      var title = term.getAttribute( 'title' ).toString();		       
			  	  txt +='<option value="'+tid+'">'+title+'<\/option>';  	
			  	}
			  	txt += '<\/select><br \/><br \/>';
			  	document.getElementById("terms").innerHTML = txt;
			  	document.getElementById("term_details").innerHTML = '';
		    }
		    else{ 
		    	document.getElementById("terms").innerHTML = '';
		    	document.getElementById("term_details").innerHTML = '';
		    }
	   }
	   document.getElementById('voc_enable').className = ''; 
	}
}

function insert_term_detail(){

	var terms = document.getElementById("sel_term");
	document.getElementById('term_details').innerHTML = '';
    document.getElementById('term_details').className = 'taxonomy_fields_loading';
	
	var term = terms.options[terms.selectedIndex].value;
    
    if(term == 'select'){
      document.getElementById('term_details').className = '';
    }
    else{
	  req = check_browser();
	  if(req) {		
	    req.onreadystatechange = insert_term_detail_html;
        req.open("POST", "?q=admin/content/taxonomy_fields/ajax", true);
        param = "op=get_term_details&tid="+term;
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("Content-length", param.length);
        req.setRequestHeader("Connection", "close");
        req.send(param);
      }
  	} 
}

function insert_term_detail_html(){
	if (req.readyState == 4 && req.status == 200){ 	
		document.getElementById("term_details").innerHTML = req.responseText;
        document.getElementById('term_details').className = '';
	}
}

function insert_field_forms(vocabulary,nid,vid){
    document.getElementById("taxonomy_fields_dynamic").className = 'taxonomy_fields_loading';
    voc_id = vocabulary;
    var taxonomy = document.getElementById('edit-taxonomy-'+vocabulary);      
    var multiple = taxonomy.multiple;
    if(multiple == false){
      //taxonomy.className = 'form-taxonomy-fields-vocabulary-running';
      var term = taxonomy.options[taxonomy.selectedIndex].value;
    }
    else{
      //taxonomy.className = 'form-taxonomy-fields-multiple-running';
       var term = new Array(); 
       for (var i = 0; i < taxonomy.options.length; i++){ 
         if (taxonomy.options[i].selected){ 
           term.push(taxonomy.options[i].value);
         }
       }
    }
    req = check_browser();
    if(req) {      
        req.onreadystatechange = insert_field_forms_html;
        req.open("POST", "?q=admin/content/taxonomy_fields/ajax", true);
        if(nid == 0){
          param = "op=get_fields&tid="+term+"&nid="+nid+"&type="+vid+"&voc="+vocabulary;
        }
        else{
          param = "op=get_fields&tid="+term+"&nid="+nid+"&vid="+vid+"&voc="+vocabulary;
        }
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("Content-length", param.length);
        req.setRequestHeader("Connection", "close");
        req.send(param);
    }  
}

function insert_field_forms_html(){

  if (req.readyState == 4 && req.status == 200){ 
    var txt = req.responseText;
    
    txt_prev = txt.split('<pre_field>');
    if(txt_prev[1]){
      for(i = 1; i <= (txt_prev.length - 1); i++){
        if(txt_prev[i]){
          prev = txt_prev[i].split('</name>');
          if(document.getElementById('tax_'+prev[0].replace('<name>',''))){
            document.getElementById('tax_'+prev[0].replace('<name>','')).innerHTML = prev[1].replace('</pre_field>','');
          }
        }
      }
    }
    
    txt_group_off = txt_prev[0].split('<group_off>');
    if(txt_group_off[1]){
      for(i = 1; i < txt_group_off.length; i++){
        element = '';    
        element = txt_group_off[i].replace('</group_off>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){
          document.getElementById('tax_'+element).className = 'taxonomy-fields-hidden';
        }
      }
    }
    
    txt_del = txt_group_off[0].split('<del_field>');
    if(txt_del[1]){
      for(i = 1; i < txt_del.length; i++){    
        element = txt_del[i].replace('</del_field>','');
        if(document.getElementById('tax_'+element)){           
          document.getElementById('tax_'+element).innerHTML = "";
        }
      }
    }

    txt_group = txt_del[0].split('<group_on>');
    if(txt_group[1]){
      for(i = 1; i < txt_group.length; i++){
        element = '';    
        element = txt_group[i].replace('</group_on>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = '';
        }
      }
    }
    txt_on_field = txt_group[0].split('<on_field>');
    if(txt_on_field[1]){
      for(i = 1; i < txt_on_field.length; i++){
        element = '';    
        element = txt_on_field[i].replace('</on_field>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = '';
        }
      }
    }
    /*
    var taxonomy = document.getElementById('edit-taxonomy-'+voc_id);
    if(taxonomy.multiple){
      taxonomy.className = 'form-taxonomy-fields-multiple';
    }
    else{
      taxonomy.className = 'form-taxonomy-fields-vocabulary';
    }
    */
    document.getElementById("taxonomy_fields_dynamic").className = '';
  }  
}

function insert_field_forms_radio(vocabulary,nid,vid,element){
    document.getElementById("taxonomy_fields_dynamic").className = 'taxonomy_fields_loading';
    req = check_browser();
    if(req) {      
        req.onreadystatechange = insert_field_forms_radio_html;
        req.open("POST", "?q=admin/content/taxonomy_fields/ajax", true);
        if(nid == 0){
          param = "op=get_fields&tid="+element+"&nid="+nid+"&type="+vid+"&voc="+vocabulary;
        }
        else{
          param = "op=get_fields&tid="+element+"&nid="+nid+"&vid="+vid+"&voc="+vocabulary;
        }
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("Content-length", param.length);
        req.setRequestHeader("Connection", "close");
        req.send(param);
    }  
}

function insert_field_forms_radio_html(){
  if (req.readyState == 4 && req.status == 200){ 
    var txt = req.responseText;

    txt_prev = txt.split('<pre_field>');
    if(txt_prev[1]){
      for(i = 1; i <= (txt_prev.length - 1); i++){
        if(txt_prev[i]){
          prev = txt_prev[i].split('</name>');
          if(document.getElementById('tax_'+prev[0].replace('<name>',''))){
            document.getElementById('tax_'+prev[0].replace('<name>','')).innerHTML = prev[1].replace('</pre_field>','');
          }
        }
      }
    }
    
    txt_group_off = txt_prev[0].split('<group_off>');
    if(txt_group_off[1]){
      for(i = 1; i < txt_group_off.length; i++){
        element = '';    
        element = txt_group_off[i].replace('</group_off>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = 'taxonomy-fields-hidden';
        }
      }
    }
    
    txt_del = txt_group_off[0].split('<del_field>');
    if(txt_del[1]){
      for(i = 1; i < txt_del.length; i++){    
        element = txt_del[i].replace('</del_field>','');
        if(document.getElementById('tax_'+element)){           
          document.getElementById('tax_'+element).innerHTML = "";
        }
      }
    }
    
    txt_group = txt_del[0].split('<group_on>');
    if(txt_group[1]){
      for(i = 1; i < txt_group.length; i++){
        element = '';    
        element = txt_group[i].replace('</group_on>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = '';
        }
      }
    }
    txt_on_field = txt_group[0].split('<on_field>');
    if(txt_on_field[1]){
      for(i = 1; i < txt_on_field.length; i++){
        element = '';    
        element = txt_on_field[i].replace('</on_field>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = '';
        }
      }
    }
    document.getElementById("taxonomy_fields_dynamic").className = '';
  }  
}

function insert_field_forms_checkboxes(vocabulary,nid,vid,term,checked){
    
    document.getElementById("taxonomy_fields_dynamic").className = 'taxonomy_fields_loading';
    req = check_browser();
    if(req) {      
        req.onreadystatechange = insert_field_forms_checkbox_html;
        req.open("POST", "?q=admin/content/taxonomy_fields/ajax", true);
        if(nid == 0){
        
          param = "op=get_fields_checkbox&tid="+term+"&nid="+nid+"&type="+vid+"&voc="+vocabulary+"&checked="+checked;
        }
        else{
          param = "op=get_fields_checkbox&tid="+term+"&nid="+nid+"&vid="+vid+"&voc="+vocabulary+"&checked="+checked;
        }
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("Content-length", param.length);
        req.setRequestHeader("Connection", "close");
        req.send(param);
    }    
}

function insert_field_forms_checkbox_html(){
  if (req.readyState == 4 && req.status == 200){ 
    var txt = req.responseText;   

    txt_prev = txt.split('<pre_field>');
    if(txt_prev[1]){
      for(i = 1; i <= (txt_prev.length - 1); i++){
        if(txt_prev[i]){
          prev = txt_prev[i].split('</name>');
          if(document.getElementById('tax_'+prev[0].replace('<name>',''))){
            document.getElementById('tax_'+prev[0].replace('<name>','')).innerHTML = prev[1].replace('</pre_field>','');
          }
        }
      }
    }
    
    txt_del = txt_prev[0].split('<del_field>');
    if(txt_del[1]){
      for(i = 1; i < txt_del.length; i++){
        element = '';    
        element = txt_del[i].replace('</del_field>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          //document.getElementById('tax_'+element).innerHTML = "";
           document.getElementById('tax_'+element).className = 'taxonomy-fields-hidden';
        }
      }
    }
    
    txt_group_off = txt_del[0].split('<group_off>');
    if(txt_group_off[1]){
      for(i = 1; i < txt_group_off.length; i++){
        element = '';    
        element = txt_group_off[i].replace('</group_off>','');
        element = element.replace(/\n/g,'');
        //alert(element);
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = 'taxonomy-fields-hidden';
        }
      }
    }
     
    txt_group = txt_group_off[0].split('<group_on>');
    if(txt_group[1]){
      for(i = 1; i < txt_group.length; i++){
        element = '';    
        element = txt_group[i].replace('</group_on>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = '';
        }
      }
    }
    txt_on_field = txt_group[0].split('<on_field>');
    if(txt_on_field[1]){
      for(i = 1; i < txt_on_field.length; i++){
        element = '';    
        element = txt_on_field[i].replace('</on_field>','');
        element = element.replace(/\n/g,'');
        if(document.getElementById('tax_'+element)){      
          document.getElementById('tax_'+element).className = '';
        }
      }
    }
    document.getElementById("taxonomy_fields_dynamic").className = '';
  }  
}