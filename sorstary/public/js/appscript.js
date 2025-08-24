function newTodo() {
  var myDialog = document.createElement("dialog");
  document.body.appendChild(myDialog)
  var text = document.createTextNode("This is a dialog window");
  myDialog.appendChild(text);
  myDialog.showModal();
}

function newForm() {
  var myForm = document.createElement("form");
  document.body.appendChild(myForm)
    var y = document.createTextNode("Form")
  myForm.appendChild(y);
  myForm.showModal();
}