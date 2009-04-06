// $Id $

//@file
//Code that operates multiselect boxes
//@author Obslogic (Mike Smith aka Lionfish)
$(document).ready(function()
 {
  //note: Doesn't matter what sort of submit button it is really (preview or submit)
  //selects all the items in the selected box (so they are actually selected) when submitted
  $('input.form-submit').click(function()
  {
    $('fieldset.multiselect select[@name$="[selected][]"]').selectAll();
  });
});

//selects all the items in the select box it is called from.
//usage $('nameofselectbox').selectAll();
//
jQuery.fn.selectAll = function()
{
  this.each(function()
  {
    for (var i=0;i<this.options.length;i++)
    {
      option = this.options[i];
      option.selected = true;
    }
  });
};


// -------------------------------------------------------------------
// hasOptions(obj)
//  Utility function to determine if an object has an options array
// -------------------------------------------------------------------
function hasOptions(obj) {
  if (obj!=null && obj.options!=null) { 
    return true; 
  }
  else {
    return false;
  }
};

function moveSelectedOptions(from_name,to_name) {

  from = document.getElementsByName(from_name)[0];
  to = document.getElementsByName(to_name)[0];

  // Move them over
  if (!hasOptions(from)) { 
    return false; 
  }

  for (var i=0; i<from.options.length; i++) {
    var o = from.options[i];
    if (o.selected) {
      if (!hasOptions(to)) { var index = 0; } else { var index=to.options.length; }
      to.options[index] = new Option( o.text, o.value, false, false);
      }
    }
  
  // Delete them from original
  for (var i=(from.options.length-1); i>=0; i--) {
    var o = from.options[i];
    if (o.selected) {
      from.options[i] = null;
      }
    }
    
  from.selectedIndex = -1;
  to.selectedIndex = -1;
};

