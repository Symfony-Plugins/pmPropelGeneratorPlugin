function selectTab(tab)
{
  var div = document.getElementById('tab_'+tab);
  var span = document.getElementById('tab_'+tab+'_link');
  
  var divs = document.getElementsByTagName('div');
  var spans = document.getElementsByTagName('span');
  
  for (d in divs)
  {
    if (divs[d].className == 'selected')
    {
      divs[d].className = 'not-selected';
      
      divs[d].parentNode.style.display = "none";
    }
  }
  
  div.className = 'selected';
  div.parentNode.style.display = "block";
  
  for (s in spans)
  {
    if (spans[s].className == 'tab_link_selected')
    {
      spans[s].className = 'tab_link_not_selected';
    }
  }
  
  span.className = 'tab_link_selected';
}

function toggleFold(fieldset)
{
  var div = document.getElementById('fold_'+fieldset);
  
  if (div.style.display == 'none')
  {
    div.style.display = 'block';
  }
  else
  {
    div.style.display = 'none';
  }
}